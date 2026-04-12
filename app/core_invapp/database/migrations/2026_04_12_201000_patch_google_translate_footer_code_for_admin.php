<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PatchGoogleTranslateFooterCodeForAdmin extends Migration
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

        $record = DB::table('settings')->where('key', 'footer_code')->first();
        if (!$record) {
            return;
        }

        $current = (string) $record->value;
        $clean = $this->removeExistingTranslateSnippet($current);
        $snippet = $this->translateSnippet();

        $value = trim($clean);
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
        $updated = trim($this->removeExistingTranslateSnippet($current));

        DB::table('settings')->where('key', 'footer_code')->update([
            'value' => $updated,
        ]);
    }

    /**
     * @param string $value
     * @return string
     */
    private function removeExistingTranslateSnippet($value)
    {
        $value = (string) $value;

        // Remove marker-wrapped version if present.
        $value = preg_replace(
            '/<!-- etfx-global-translate-start -->.*?<!-- etfx-global-translate-end -->/s',
            '',
            $value
        );

        // Remove legacy static block injected previously.
        $legacyStart = strpos($value, '<div id="etfx-global-translate"');
        if ($legacyStart !== false) {
            $legacyEnd = strpos($value, '</script>', $legacyStart);
            if ($legacyEnd !== false) {
                $legacyEnd += strlen('</script>');
                $value = substr($value, 0, $legacyStart) . substr($value, $legacyEnd);
            } else {
                $value = substr($value, 0, $legacyStart);
            }
        }

        return preg_replace("/\n{3,}/", "\n\n", trim((string) $value));
    }

    /**
     * @return string
     */
    private function translateSnippet()
    {
        return <<<'HTML'
<!-- etfx-global-translate-start -->
<script>
(function(){
  if (window.__etfxGlobalTranslateLoaded) { return; }
  if (/^\/admin(\/|$)/i.test(window.location.pathname)) { return; }
  window.__etfxGlobalTranslateLoaded = true;

  var style = document.createElement('style');
  style.textContent = '#etfx-global-translate{position:fixed;left:14px;bottom:14px;z-index:9999;background:#ffffff;border:1px solid #d8e8de;border-radius:999px;padding:6px 12px;box-shadow:0 10px 24px rgba(15,122,74,.16)}'
    + '#etfx-global-translate .goog-te-gadget{font-family:Arial,sans-serif!important;font-size:0!important;line-height:1}'
    + '#etfx-global-translate .goog-te-combo{margin:0!important;border:0!important;outline:0!important;background:#ffffff!important;color:#14261b!important;font-size:12px!important;font-weight:700!important}'
    + '#etfx-global-translate .goog-te-combo option{color:#14261b!important;background:#ffffff!important}'
    + '.goog-te-banner-frame.skiptranslate{display:none!important}'
    + 'body{top:0!important}';
  document.head.appendChild(style);

  var mount = document.createElement('div');
  mount.id = 'etfx-global-translate';
  document.body.appendChild(mount);

  window.etfxGlobalTranslateInit = function() {
    new google.translate.TranslateElement({ pageLanguage: 'en', autoDisplay: false }, 'etfx-global-translate');
  };

  var script = document.createElement('script');
  script.src = 'https://translate.google.com/translate_a/element.js?cb=etfxGlobalTranslateInit';
  script.async = true;
  document.head.appendChild(script);
})();
</script>
<!-- etfx-global-translate-end -->
HTML;
    }
}
