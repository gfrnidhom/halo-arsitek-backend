<?php

namespace App\Livewire\Admin\News;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class NewsIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categoryFilter = '';
    public string $publishedFilter = '';
    public bool $showDeleteModal = false;
    public ?string $deleteId = null;
    public string $deleteTitle = '';

    protected $queryString = ['search' => ['except' => ''], 'categoryFilter' => ['except' => ''], 'publishedFilter' => ['except' => '']];

    public function updatingSearch(): void { $this->resetPage(); }

    public function togglePublish(string $id): void
    {
        $news = News::findOrFail($id);
        $news->update(['is_published' => !$news->is_published]);
        ActivityLog::logActivity($news->is_published ? 'NEWS_PUBLISHED' : 'NEWS_UNPUBLISHED', "News: {$news->title}", auth()->user(), request()->ip());
    }

    public function confirmDelete(string $id, string $title): void
    {
        $this->deleteId = $id;
        $this->deleteTitle = $title;
        $this->showDeleteModal = true;
    }

    public function deleteNews(): void
    {
        if ($this->deleteId) {
            $news = News::findOrFail($this->deleteId);
            $title = $news->title;
            $news->delete();
            ActivityLog::logActivity('NEWS_DELETED', "News: {$title}", auth()->user(), request()->ip());
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $query = News::with('category')
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->categoryFilter, fn($q) => $q->where('category_id', $this->categoryFilter))
            ->when($this->publishedFilter !== '', fn($q) => $q->where('is_published', $this->publishedFilter === '1'))
            ->orderByDesc('created_at');

        return view('livewire.admin.news.index', [
            'newsList' => $query->paginate(15),
            'categories' => NewsCategory::orderBy('name')->get(),
        ])->layout('layouts.admin', ['title' => 'News & Articles', 'subtitle' => 'Manage website news and blog posts']);
    }
}
