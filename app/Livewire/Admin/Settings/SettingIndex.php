<?php

namespace App\Livewire\Admin\Settings;

use App\Models\SiteSetting;
use App\Models\ActivityLog;
use Livewire\Component;

class SettingIndex extends Component
{
    public array $settings = [];

    public function mount(): void
    {
        $this->loadSettings();
    }

    public function loadSettings(): void
    {
        $keys = [
            'site_name' => ['default' => 'Halo Arsitek', 'type' => 'STRING', 'label' => 'Website Name', 'group' => 'General'],
            'site_tagline' => ['default' => 'Jasa Arsitek & Desain Interior Premium', 'type' => 'STRING', 'label' => 'Tagline', 'group' => 'General'],
            'contact_email' => ['default' => 'info@haloarsitek.com', 'type' => 'STRING', 'label' => 'Contact Email', 'group' => 'Contact'],
            'contact_phone' => ['default' => '+62 812-3456-7890', 'type' => 'STRING', 'label' => 'WhatsApp / Phone', 'group' => 'Contact'],
            'contact_address' => ['default' => 'Jl. Arsitektur No. 1, Jakarta Selatan, Indonesia', 'type' => 'STRING', 'label' => 'Office Address', 'group' => 'Contact'],
            'social_instagram' => ['default' => 'https://instagram.com/haloarsitek', 'type' => 'STRING', 'label' => 'Instagram URL', 'group' => 'Social Media'],
            'social_facebook' => ['default' => 'https://facebook.com/haloarsitek', 'type' => 'STRING', 'label' => 'Facebook URL', 'group' => 'Social Media'],
            'social_youtube' => ['default' => 'https://youtube.com/@haloarsitek', 'type' => 'STRING', 'label' => 'YouTube URL', 'group' => 'Social Media'],
            'seo_meta_description' => ['default' => 'Halo Arsitek adalah konsultan arsitek dan desain interior terpercaya di Indonesia.', 'type' => 'STRING', 'label' => 'Meta Description', 'group' => 'SEO'],
        ];

        foreach ($keys as $key => $meta) {
            $value = SiteSetting::getValue($key, $meta['default']);
            $this->settings[$key] = [
                'value' => $value,
                'type' => $meta['type'],
                'label' => $meta['label'],
                'group' => $meta['group'],
            ];
        }
    }

    public function save(): void
    {
        foreach ($this->settings as $key => $meta) {
            SiteSetting::setValue($key, $meta['value'], $meta['type']);
        }

        ActivityLog::logActivity('SETTINGS_UPDATED', 'Updated website configurations', auth()->user(), request()->ip());
        session()->flash('success', 'Settings updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.settings.index')
            ->layout('layouts.admin', ['title' => 'Site Settings', 'subtitle' => 'Configure global website settings and contact info']);
    }
}
