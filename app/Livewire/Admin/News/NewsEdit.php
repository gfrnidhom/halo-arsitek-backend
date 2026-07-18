<?php

namespace App\Livewire\Admin\News;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewsEdit extends Component
{
    use WithFileUploads;

    public string $newsId;
    public string $title = '';
    public string $slug = '';
    public string $category_id = '';
    public string $content = '';
    public $cover_image_file = null;
    public string $cover_image = '';
    public bool $is_published = false;

    public function mount(string $id): void
    {
        $news = News::findOrFail($id);
        $this->newsId = $news->id;
        $this->title = $news->title;
        $this->slug = $news->slug;
        $this->category_id = $news->category_id;
        $this->content = $news->content;
        $this->cover_image = $news->cover_image;
        $this->is_published = $news->is_published;
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|regex:/^[a-z0-9-]+$/|unique:news,slug,' . $this->newsId,
            'category_id' => 'required|exists:news_categories,id',
            'content' => 'required|string',
            'cover_image' => 'required|string|max:500',
            'is_published' => 'boolean',
        ];
    }

    public function updatedCoverImageFile(): void
    {
        $this->validate(['cover_image_file' => 'image|max:5120']);
        $path = $this->cover_image_file->store('uploads/news/' . date('Y/m'), 'public');
        $this->cover_image = '/storage/' . $path;
    }

    public function save()
    {
        $this->validate();

        $news = News::findOrFail($this->newsId);
        $news->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
            'content' => $this->content,
            'cover_image' => $this->cover_image,
            'is_published' => $this->is_published,
        ]);

        ActivityLog::logActivity('NEWS_UPDATED', "News: {$news->title}", auth()->user(), request()->ip());

        session()->flash('success', 'Article updated successfully!');
        return redirect()->route('admin.news.index');
    }

    public function render()
    {
        return view('livewire.admin.news.form', [
            'categories' => NewsCategory::orderBy('name')->get(),
            'isEdit' => true,
        ])->layout('layouts.admin', ['title' => 'Edit Article', 'subtitle' => 'Update article details']);
    }
}
