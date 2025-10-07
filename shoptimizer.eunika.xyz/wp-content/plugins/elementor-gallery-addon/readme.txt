=== Elementor Gallery Addon ===
Contributors: eunikaagency  
Requires at least: 6.0  
Tested up to: 6.5  
Stable tag: 1.1  
Tags: gallery, swiper, elementor, slider, grid, captions, responsive  

== Description ==  
Flexible Swiper-based gallery widget for Elementor. Supports slider, multi-row grid, static grid, overlay captions, hover effects, custom spacing, and per-widget CSS.

== Features ==  
- Slider Mode (Single Row)  
- Multi-Row Swiper Grid  
- Static Grid Layout (No Slider)  
- Overlay or Below Image Captions  
- Hover-to-Show Captions by Device (Desktop, Tablet, Mobile)  
- Spacing, Border Radius, and Slide Height Controls  
- Per-Widget Custom CSS Editor  
- Fully Responsive  
- Clickable Slide Links with Target and Nofollow options  

== Theming Guide ==  
To customise gallery appearance:  
- Edit `/assets/css/gallery.css` for core styling  
- Optional: Add additional stylesheets for site-specific variations  

Useful CSS Classes:  
- `.gallery-container` — Outer container  
- `.swiper-slide` — Each slide (Slider Mode)  
- `.grid-item` — Each grid item (Static Grid Mode)  
- `.image-container` — Image wrapper, replaced with `<a>` if slide has URL  
- `.caption` — Below image captions  
- `.caption-overlay` — Full overlay captions  
- `.caption-overlay.overlay-top | .overlay-center | .overlay-bottom` — Overlay positioning  
- `.hover-overlay-desktop | .hover-overlay-tablet | .hover-overlay-mobile` — Hover-controlled captions  

CSS Variables for Customisation:  
- `--ega-slide-height` — Forces slide or grid item height  
- `--ega-overlay-padding` — Controls overlay caption padding  
- `--ega-caption-padding` — Controls below caption padding  

Custom CSS can also be injected per widget via the Elementor editor.

== Installation ==  
1. Upload plugin folder to `/wp-content/plugins/`  
2. Activate via WordPress admin  
3. Edit any Elementor page, search "Gallery Slider" widget  

== Changelog ==  
1.1 - Added Grid Mode support, device-specific hover captions, unified height & padding controls, clickable slide links  
1.0 - Initial Release  
