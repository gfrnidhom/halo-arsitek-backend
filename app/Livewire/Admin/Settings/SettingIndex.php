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

    public function getSettingSchema(): array
    {
        return [
            // General
            'site_name' => ['default' => 'Halo Arsitek', 'type' => 'STRING', 'label' => 'Website Name', 'group' => 'General'],
            'site_tagline' => ['default' => 'Jasa Arsitek & Desain Interior Premium', 'type' => 'STRING', 'label' => 'Website Tagline', 'group' => 'General'],
            'site_logo' => ['default' => '', 'type' => 'STRING', 'label' => 'Logo URL (Optional)', 'group' => 'General'],
            'site_favicon' => ['default' => '', 'type' => 'STRING', 'label' => 'Favicon URL (Optional)', 'group' => 'General'],
            
            // Hero & About (Company)
            'hero_tagline' => ['default' => 'Menciptakan Ruang, Membangun Cerita', 'type' => 'STRING', 'label' => 'Hero Tagline', 'group' => 'Company'],
            'hero_subtitle' => ['default' => 'Studio arsitektur profesional dengan pengalaman 15+ tahun', 'type' => 'STRING', 'label' => 'Hero Subtitle', 'group' => 'Company'],
            'about_description' => ['default' => 'Kami adalah tim arsitek berpengalaman yang berkomitmen menciptakan karya arsitektur yang fungsional, estetik, dan berkelanjutan.', 'type' => 'STRING', 'label' => 'About Description', 'group' => 'Company'],

            // Statistics
            'stat_projects' => ['default' => '200', 'type' => 'NUMBER', 'label' => 'Total Projects', 'group' => 'Statistics'],
            'stat_years' => ['default' => '15', 'type' => 'NUMBER', 'label' => 'Years of Experience', 'group' => 'Statistics'],
            'stat_awards' => ['default' => '50', 'type' => 'NUMBER', 'label' => 'Awards Won', 'group' => 'Statistics'],
            'stat_clients' => ['default' => '180', 'type' => 'NUMBER', 'label' => 'Happy Clients', 'group' => 'Statistics'],

            // Contact
            'contact_email' => ['default' => 'hello@haloarsitek.com', 'type' => 'STRING', 'label' => 'Contact Email', 'group' => 'Contact'],
            'contact_phone' => ['default' => '+62 812 3456 7890', 'type' => 'STRING', 'label' => 'Phone Number', 'group' => 'Contact'],
            'contact_whatsapp' => ['default' => '6281234567890', 'type' => 'STRING', 'label' => 'WhatsApp Number', 'group' => 'Contact'],
            'contact_address' => ['default' => 'Jl. Arsitektur No. 42, Jakarta Selatan, DKI Jakarta 12345', 'type' => 'STRING', 'label' => 'Office Address', 'group' => 'Contact'],
            'contact_map_url' => ['default' => '', 'type' => 'STRING', 'label' => 'Google Maps Embed URL', 'group' => 'Contact'],
            'contact_working_hours' => ['default' => 'Senin - Jumat, 09:00 - 17:00', 'type' => 'STRING', 'label' => 'Working Hours', 'group' => 'Contact'],

            // Social Media
            'social_instagram' => ['default' => 'https://instagram.com/haloarsitek', 'type' => 'STRING', 'label' => 'Instagram URL', 'group' => 'Social Media'],
            'social_facebook' => ['default' => 'https://facebook.com/haloarsitek', 'type' => 'STRING', 'label' => 'Facebook URL', 'group' => 'Social Media'],
            'social_youtube' => ['default' => 'https://youtube.com/@haloarsitek', 'type' => 'STRING', 'label' => 'YouTube URL', 'group' => 'Social Media'],
            'social_linkedin' => ['default' => 'https://linkedin.com/company/haloarsitek', 'type' => 'STRING', 'label' => 'LinkedIn URL', 'group' => 'Social Media'],
            'social_tiktok' => ['default' => '', 'type' => 'STRING', 'label' => 'TikTok URL', 'group' => 'Social Media'],

            // SEO & Meta
            'seo_meta_description' => ['default' => 'Halo Arsitek adalah konsultan arsitek dan desain interior terpercaya di Indonesia.', 'type' => 'STRING', 'label' => 'Meta Description', 'group' => 'SEO'],
            'seo_meta_keywords' => ['default' => 'arsitek, desain interior, kontraktor, arsitek jakarta', 'type' => 'STRING', 'label' => 'Meta Keywords', 'group' => 'SEO'],
            'seo_author' => ['default' => 'Halo Arsitek', 'type' => 'STRING', 'label' => 'SEO Author', 'group' => 'SEO'],

            // Integrations
            'integration_ga_id' => ['default' => '', 'type' => 'STRING', 'label' => 'Google Analytics Measurement ID', 'group' => 'Integrations'],
            'integration_fb_pixel' => ['default' => '', 'type' => 'STRING', 'label' => 'Facebook Pixel ID', 'group' => 'Integrations'],
        ];
    }

    public function loadSettings(): void
    {
        foreach ($this->getSettingSchema() as $key => $meta) {
            $this->settings[$key] = SiteSetting::getValue($key, $meta['default']);
        }
    }

    public function save(): void
    {
        $schema = $this->getSettingSchema();
        foreach ($this->settings as $key => $value) {
            $meta = $schema[$key] ?? null;
            if ($meta) {
                SiteSetting::setValue($key, $value, $meta['type']);
            }
        }

        ActivityLog::logActivity('SETTINGS_UPDATED', 'Updated website configurations', auth()->user(), request()->ip());
        session()->flash('success', 'Settings updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.settings.index', [
            'schema' => $this->getSettingSchema()
        ])->layout('layouts.admin', ['title' => 'Site Settings', 'subtitle' => 'Configure global website settings and contact info']);
    }
}
