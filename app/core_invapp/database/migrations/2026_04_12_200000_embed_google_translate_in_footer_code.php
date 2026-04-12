<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EmbedGoogleTranslateInFooterCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('settings')) {
            return;
        }

        $snippet = $this->translateSnippet();
        $record = DB::table('settings')->where('key', 'footer_code')->first();

        if (!$record) {
            DB::table('settings')->insert([
                'key' => 'footer_code',
                'value' => $snippet,
                'created_at' => now(),
            ]);
            return;
        }

        $current = (string) $record->value;
        if (strpos($current, 'id="etfx-global-translate"') !== false) {
            return;
        }

        $value = trim($current);
        $value = $value !== '' ? $value . "\n\n" . $snippet : $snippet;

        DB::table('settings')->where('key', 'footer_code')->update([
            'value' => $value,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('settings')) {
            return;
        }

        $record = DB::table('settings')->where('key', 'footer_code')->first();
        if (!$record) {
            return;
        }

        $current = (string) $record->value;
        $snippet = $this->translateSnippet();
        if (strpos($current, 'id="etfx-global-translate"') === false) {
            return;
        }

        $updated = str_replace($snippet, '', $current);
        $updated = preg_replace("/\n{3,}/", "\n\n", $updated);
        $updated = trim((string) $updated);

        DB::table('settings')->where('key', 'footer_code')->update([
            'value' => $updated,
        ]);
    }

    /**
     * @return string
     */
    private function translateSnippet()
    {
        return <<<'HTML'
<div id="etfx-global-translate" style="position:fixed;left:14px;bottom:14px;z-index:9999;background:#ffffff;border:1px solid #d8e8de;border-radius:999px;padding:6px 12px;box-shadow:0 10px 24px rgba(15,122,74,.16);"></div>
<style>
#etfx-global-translate .goog-te-gadget{font-family:Arial,sans-serif!important;font-size:0!important;line-height:1}
#etfx-global-translate .goog-te-combo{margin:0!important;border:0!important;outline:0!important;background:#ffffff!important;color:#14261b!important;font-size:12px!important;font-weight:700!important}
#etfx-global-translate .goog-te-combo option{color:#14261b!important;background:#ffffff!important}
.goog-te-banner-frame.skiptranslate{display:none!important}
body{top:0!important}
</style>
<script>
(function(){if(window.__etfxGlobalTranslateLoaded){return;}window.__etfxGlobalTranslateLoaded=true;window.etfxGlobalTranslateInit=function(){new google.translate.TranslateElement({pageLanguage:'en',autoDisplay:false},'etfx-global-translate');};var s=document.createElement('script');s.src='https://translate.google.com/translate_a/element.js?cb=etfxGlobalTranslateInit';s.async=true;document.head.appendChild(s);})();
</script>
HTML;
    }
}
