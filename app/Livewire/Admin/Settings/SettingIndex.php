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
            // General
            'site_name' => ['default' => 'Halo Arsitek', 'type' => 'STRING', 'label' => 'Website Name', 'group' => 'General'],
            'site_tagline' => ['default' => 'Jasa Arsitek & Desain Interior Premium', 'type' => 'STRING', 'label' => 'Tagline', 'group' => 'General'],
            'site_logo' => ['default' => '', 'type' => 'STRING', 'label' => 'Logo URL (Optional)', 'group' => 'General'],
            'site_favicon' => ['default' => '', 'type' => 'STRING', 'label' => 'Favicon URL (Optional)', 'group' => 'General'],
            
            // Contact
            'contact_email' => ['default' => 'info@haloarsitek.com', 'type' => 'STRING', 'label' => 'Contact Email', 'group' => 'Contact'],
            'contact_phone' => ['default' => '+62 812-3456-7890', 'type' => 'STRING', 'label' => 'WhatsApp / Phone', 'group' => 'Contact'],
            'contact_address' => ['default' => 'Jl. Arsitektur No. 1, Jakarta Selatan, Indonesia', 'type' => 'STRING', 'label' => 'Office Address', 'group' => 'Contact'],
            'contact_map_url' => ['default' => '', 'type' => 'STRING', 'label' => 'Google Maps Embed URL', 'group' => 'Contact'],
            'contact_working_hours' => ['default' => 'Senin - Jumat, 09:00 - 17:00', 'type' => 'STRING', 'label' => 'Working Hours', 'group' => 'Contact'],

            // Social Media
            'social_instagram' => ['default' => 'https://instagram.com/haloarsitek', 'type' => 'STRING', 'label' => 'Instagram URL', 'group' => 'Social Media'],
            'social_facebook' => ['default' => 'https://facebook.com/haloarsitek', 'type' => 'STRING', 'label' => 'Facebook URL', 'group' => 'Social Media'],
            'social_youtube' => ['default' => 'https://youtube.com/@haloarsitek', 'type' => 'STRING', 'label' => 'YouTube URL', 'group' => 'Social Media'],
            'social_linkedin' => ['default' => '', 'type' => 'STRING', 'label' => 'LinkedIn URL', 'group' => 'Social Media'],
            'social_tiktok' => ['default' => '', 'type' => 'STRING', 'label' => 'TikTok URL', 'group' => 'Social Media'],

            // SEO & Meta
            'seo_meta_description' => ['default' => 'Halo Arsitek adalah konsultan arsitek dan desain interior terpercaya di Indonesia.', 'type' => 'STRING', 'label' => 'Meta Description', 'group' => 'SEO'],
            'seo_meta_keywords' => ['default' => 'arsitek, desain interior, kontraktor, arsitek jakarta', 'type' => 'STRING', 'label' => 'Meta Keywords', 'group' => 'SEO'],
            'seo_author' => ['default' => 'Halo Arsitek', 'type' => 'STRING', 'label' => 'SEO Author', 'group' => 'SEO'],

            // Integrations
            'integration_ga_id' => ['default' => '', 'type' => 'STRING', 'label' => 'Google Analytics Measurement ID', 'group' => 'Integrations'],
            'integration_fb_pixel' => ['default' => '', 'type' => 'STRING', 'label' => 'Facebook Pixel ID', 'group' => 'Integrations'],
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
