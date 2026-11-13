# 🌿 AURA Nature 3D Background - Documentation & Integration Guide

A high-performance, realistic, procedural 3D animated nature environment inspired by a magical tropical forest, designed to serve as an immersive live background for modern websites.

---

## ✨ Features & Visual Elements

1. **Procedural 3D Forest & Canopy:**
   - Realistic organic trees with textured bark and multi-layered foliage.
   - Dynamic wind simulation: Trees and individual leaf clusters sway gently with sinusoidal harmonics.

2. **Flowing Water & Cascading Waterfall:**
   - Custom animated GLSL water shader with normal ripple perturbations and sunlight glint/fresnel specular highlights.
   - Cascading waterfall ribbon between rocks with dynamic foam lines.
   - Billowing waterfall mist particles rising from the splash base.

3. **Multi-Layered Mountains & Atmospheric Depth:**
   - 3-tier mountain ridge silhouettes with procedural elevation.
   - Atmospheric fog (`THREE.FogExp2`) dynamically matching the time-of-day sky dome.
   - Drifting procedural volumetric clouds moving slowly across the horizon.

4. **Volumetric Sunlight & Magical Micro-Elements:**
   - God rays (light shafts) slicing through the forest canopy.
   - Floating golden dust motes / pollen drifting in 3D air currents.
   - Bioluminescent fireflies that pulse and hover naturally.
   - Glowing exotic forest flowers along the riverbanks.

5. **Smooth Animation & Parallax Interaction:**
   - Automatic cinematic drone flythrough camera glide.
   - Responsive mouse / touch / gyroscope parallax with smooth damping (`lerp`).
   - Four atmospheric moods: **Morning Mist**, **Sunny Noon**, **Golden Sunset**, **Enchanted Night**.
   - Built-in Web Audio API nature sound synthesizer (waterfall and forest river breeze, zero external audio files required).

6. **Ultra-Optimized Architecture:**
   - 100% procedural geometry and canvas-generated textures (no slow megabyte GLTF model downloads).
   - High performance across both mobile and desktop (clamped device pixel ratio, instanced meshes, efficient shaders).

---

## 🚀 Quick Start & Integration

### Step 1: Include the Assets
Copy the files from `assets/` into your project:
```html
<!-- Nature Background Styles -->
<link rel="stylesheet" href="assets/nature-background.css">

<!-- Three.js (Local or CDN) -->
<script src="assets/three/three.min.js"></script>

<!-- Nature 3D Background Engine -->
<script src="assets/nature-background.js"></script>
```

### Step 2: Add Container Element
Add the background container element behind your content:
```html
<div id="nature-3d-bg"></div>
```

### Step 3: Initialize the Scene
```javascript
const natureBg = new NatureBackground3D({
  container: '#nature-3d-bg', // Container element or selector
  preset: 'morning',          // 'morning', 'noon', 'sunset', 'night'
  windSpeed: 1.0,             // 0.0 to 3.0
  cinematicFlight: true,      // true: slow organic drone flight; false: fixed parallax
  cameraParallax: true,       // mouse & gyroscope parallax
  interactive: true           // enable cursor tracking
});
```

---

## ⚙️ JavaScript API Reference

| Method | Parameters | Description |
|---|---|---|
| `setPreset(name)` | `'morning' \| 'noon' \| 'sunset' \| 'night'` | Changes sky, lighting, fog, and firefly colors smoothly. |
| `setWindSpeed(value)` | `number (0.0 to 3.0)` | Adjusts tree sway and leaf fluttering speed. |
| `setCinematicFlight(enable)` | `boolean` | Toggles automatic cinematic camera flight on or off. |
| `toggleAudio(forceState?)` | `boolean (optional)` | Toggles procedural nature stream sound. |
| `destroy()` | None | Cancels animation frame, detaches listeners, and disposes WebGL resources. |

---

## 🎨 File Structure

- [nature-demo.html](file:///d:/xampp/htdocs/KasirSMKN4/nature-demo.html) - Complete modern website showcase featuring glassmorphic UI and live interactive controls HUD.
- [assets/nature-background.js](file:///d:/xampp/htdocs/KasirSMKN4/assets/nature-background.js) - Core 3D engine, procedural terrain, shaders, wind, water, and particle systems.
- [assets/nature-background.css](file:///d:/xampp/htdocs/KasirSMKN4/assets/nature-background.css) - Fullscreen background styling, glassmorphism cards, and HUD controls.
- [assets/three/three.min.js](file:///d:/xampp/htdocs/KasirSMKN4/assets/three/three.min.js) - Standalone local Three.js bundle for offline and fast loading.
