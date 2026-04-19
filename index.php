<?php
/**
 * Main template with PHP fallback for Customizer and front-end reliability.
 *
 * @package ViteReactTheme
 */
get_header();

$hero_title    = get_theme_mod( 'vrt_hero_title', 'Build Something Amazing' );
$hero_subtitle = get_theme_mod( 'vrt_hero_subtitle', 'A modern WordPress theme with clean design, powerful customization, and stunning animations.' );
$hero_badge    = get_theme_mod( 'vrt_hero_badge', 'Welcome to the future' );
$hero_btn1     = get_theme_mod( 'vrt_hero_btn1_text', 'Get Started' );
$hero_btn1_url = get_theme_mod( 'vrt_hero_btn1_url', '#features' );
$hero_btn2     = get_theme_mod( 'vrt_hero_btn2_text', 'Learn More' );
$hero_btn2_url = get_theme_mod( 'vrt_hero_btn2_url', '#latest-posts' );
$hero_image    = get_theme_mod( 'vrt_hero_bg_image', '' );
?>

<style>
.vrt-static-preview {
  background: linear-gradient(180deg, #090b14 0%, #111827 100%);
  color: #f8fafc;
  min-height: 100vh;
}
.vrt-static-preview * { box-sizing: border-box; }
.vrt-static-shell {
  width: min(1200px, calc(100% - 32px));
  margin: 0 auto;
  padding: 96px 0 64px;
}
.vrt-static-hero {
  display: grid;
  grid-template-columns: minmax(0, 1.05fr) minmax(280px, 0.95fr);
  gap: 32px;
  align-items: center;
  min-height: 70vh;
}
.vrt-static-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 14px;
  border-radius: 999px;
  background: rgba(99, 102, 241, 0.18);
  color: #c7d2fe;
  font-size: 14px;
  margin-bottom: 20px;
}
.vrt-static-title {
  margin: 0;
  font-size: clamp(2.5rem, 6vw, 4.75rem);
  line-height: 1.02;
  letter-spacing: -0.04em;
}
.vrt-static-subtitle {
  margin: 20px 0 0;
  max-width: 44rem;
  color: #cbd5e1;
  font-size: 1.1rem;
  line-height: 1.8;
}
.vrt-static-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 14px;
  margin-top: 28px;
}
.vrt-static-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 48px;
  padding: 0 20px;
  border-radius: 999px;
  text-decoration: none;
  font-weight: 600;
}
.vrt-static-btn-primary {
  background: #6366f1;
  color: #fff;
}
.vrt-static-btn-secondary {
  background: rgba(255,255,255,0.08);
  color: #fff;
  border: 1px solid rgba(255,255,255,0.14);
}
.vrt-static-media {
  min-height: 320px;
  border-radius: 28px;
  overflow: hidden;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(255,255,255,0.04);
  box-shadow: 0 30px 80px rgba(0,0,0,0.35);
}
.vrt-static-media img {
  display: block;
  width: 100%;
  height: 100%;
  min-height: 320px;
  object-fit: cover;
}
.vrt-static-placeholder {
  display: grid;
  place-items: center;
  min-height: 320px;
  padding: 24px;
  color: #94a3b8;
  text-align: center;
}
@media (max-width: 900px) {
  .vrt-static-shell { padding-top: 72px; }
  .vrt-static-hero { grid-template-columns: 1fr; }
}
</style>

<div id="vrt-static-preview" class="vrt-static-preview">
  <div class="vrt-static-shell">
    <section class="vrt-static-hero">
      <div>
        <?php if ( ! empty( $hero_badge ) ) : ?>
          <div class="vrt-static-badge"><?php echo esc_html( $hero_badge ); ?></div>
        <?php endif; ?>

        <h1 class="vrt-static-title"><?php echo esc_html( $hero_title ); ?></h1>
        <p class="vrt-static-subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>

        <div class="vrt-static-actions">
          <?php if ( ! empty( $hero_btn1 ) ) : ?>
            <a class="vrt-static-btn vrt-static-btn-primary" href="<?php echo esc_url( $hero_btn1_url ?: '#features' ); ?>"><?php echo esc_html( $hero_btn1 ); ?></a>
          <?php endif; ?>
          <?php if ( ! empty( $hero_btn2 ) ) : ?>
            <a class="vrt-static-btn vrt-static-btn-secondary" href="<?php echo esc_url( $hero_btn2_url ?: '#latest-posts' ); ?>"><?php echo esc_html( $hero_btn2 ); ?></a>
          <?php endif; ?>
        </div>
      </div>

      <div class="vrt-static-media">
        <?php if ( ! empty( $hero_image ) ) : ?>
          <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( $hero_title ); ?>" />
        <?php else : ?>
          <div class="vrt-static-placeholder">Upload a Hero Background Image in the Customizer to show it here.</div>
        <?php endif; ?>
      </div>
    </section>
  </div>
</div>

<div id="vrt-app"></div>

<script>
(function() {
  var attempts = 0;
  function syncFallbackVisibility() {
    var fallback = document.getElementById('vrt-static-preview');
    var appRoot = document.getElementById('vrt-app');
    if (!fallback || !appRoot) {
      return;
    }

    if (appRoot.children.length > 0) {
      fallback.style.display = 'none';
      return;
    }

    attempts += 1;
    if (attempts < 20) {
      setTimeout(syncFallbackVisibility, 250);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', syncFallbackVisibility);
  } else {
    syncFallbackVisibility();
  }
})();
</script>

<?php get_footer(); ?>
