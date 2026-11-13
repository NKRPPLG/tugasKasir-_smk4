/**
 * NatureBackground3D - Immersive Magical Forest 3D Animated Background
 * Built with Three.js (Procedural, High Performance, Responsive)
 */

(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define(['three'], factory);
  } else if (typeof module === 'object' && module.exports) {
    module.exports = factory(require('three'));
  } else {
    root.NatureBackground3D = factory(root.THREE);
  }
})(typeof self !== 'undefined' ? self : this, function (THREE) {
  'use strict';

  // --- Perlin / Simplex Noise Implementation (Lightweight 3D Noise) ---
  const Simplex = (function () {
    const F3 = 1.0 / 3.0, G3 = 1.0 / 6.0;
    const p = new Uint8Array(256);
    for (let i = 0; i < 256; i++) p[i] = Math.floor(Math.random() * 256);
    const perm = new Uint8Array(512);
    const permMod12 = new Uint8Array(512);
    for (let i = 0; i < 512; i++) {
      perm[i] = p[i & 255];
      permMod12[i] = (perm[i] % 12);
    }
    const grad3 = new Float32Array([
      1, 1, 0, -1, 1, 0, 1, -1, 0, -1, -1, 0,
      1, 0, 1, -1, 0, 1, 1, 0, -1, -1, 0, -1,
      0, 1, 1, 0, -1, 1, 0, 1, -1, 0, -1, -1
    ]);

    return {
      noise2D: function (xin, yin) {
        return this.noise3D(xin, yin, 0.5);
      },
      noise3D: function (xin, yin, zin) {
        let n0, n1, n2, n3;
        const s = (xin + yin + zin) * F3;
        const i = Math.floor(xin + s), j = Math.floor(yin + s), k = Math.floor(zin + s);
        const t = (i + j + k) * G3;
        const X0 = i - t, Y0 = j - t, Z0 = k - t;
        const x0 = xin - X0, y0 = yin - Y0, z0 = zin - Z0;
        let i1, j1, k1, i2, j2, k2;
        if (x0 >= y0) {
          if (y0 >= z0) { i1 = 1; j1 = 0; k1 = 0; i2 = 1; j2 = 1; k2 = 0; }
          else if (x0 >= z0) { i1 = 1; j1 = 0; k1 = 0; i2 = 1; j2 = 0; k2 = 1; }
          else { i1 = 0; j1 = 0; k1 = 1; i2 = 1; j2 = 0; k2 = 1; }
        } else {
          if (y0 < z0) { i1 = 0; j1 = 0; k1 = 1; i2 = 0; j2 = 1; k2 = 1; }
          else if (x0 < z0) { i1 = 0; j1 = 1; k1 = 0; i2 = 0; j2 = 1; k2 = 1; }
          else { i1 = 0; j1 = 1; k1 = 0; i2 = 1; j2 = 1; k2 = 0; }
        }
        const x1 = x0 - i1 + G3, y1 = y0 - j1 + G3, z1 = z0 - k1 + G3;
        const x2 = x0 - i2 + 2.0 * G3, y2 = y0 - j2 + 2.0 * G3, z2 = z0 - k2 + 2.0 * G3;
        const x3 = x0 - 1.0 + 3.0 * G3, y3 = y0 - 1.0 + 3.0 * G3, z3 = z0 - 1.0 + 3.0 * G3;
        const ii = i & 255, jj = j & 255, kk = k & 255;
        let gi0 = permMod12[ii + perm[jj + perm[kk]]] * 3;
        let gi1 = permMod12[ii + i1 + perm[jj + j1 + perm[kk + k1]]] * 3;
        let gi2 = permMod12[ii + i2 + perm[jj + j2 + perm[kk + k2]]] * 3;
        let gi3 = permMod12[ii + 1 + perm[jj + 1 + perm[kk + 1]]] * 3;
        let t0 = 0.6 - x0 * x0 - y0 * y0 - z0 * z0;
        if (t0 < 0) n0 = 0.0; else { t0 *= t0; n0 = t0 * t0 * (grad3[gi0] * x0 + grad3[gi0 + 1] * y0 + grad3[gi0 + 2] * z0); }
        let t1 = 0.6 - x1 * x1 - y1 * y1 - z1 * z1;
        if (t1 < 0) n1 = 0.0; else { t1 *= t1; n1 = t1 * t1 * (grad3[gi1] * x1 + grad3[gi1 + 1] * y1 + grad3[gi1 + 2] * z1); }
        let t2 = 0.6 - x2 * x2 - y2 * y2 - z2 * z2;
        if (t2 < 0) n2 = 0.0; else { t2 *= t2; n2 = t2 * t2 * (grad3[gi2] * x2 + grad3[gi2 + 1] * y2 + grad3[gi2 + 2] * z2); }
        let t3 = 0.6 - x3 * x3 - y3 * y3 - z3 * z3;
        if (t3 < 0) n3 = 0.0; else { t3 *= t3; n3 = t3 * t3 * (grad3[gi3] * x3 + grad3[gi3 + 1] * y3 + grad3[gi3 + 2] * z3); }
        return 32.0 * (n0 + n1 + n2 + n3);
      },
      fbm: function (x, y, octaves = 4) {
        let val = 0, amp = 0.5, freq = 1;
        for (let i = 0; i < octaves; i++) {
          val += amp * this.noise2D(x * freq, y * freq);
          amp *= 0.5;
          freq *= 2.0;
        }
        return val;
      }
    };
  })();

  // --- Procedural Texture Generators ---
  function createGlowTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 128;
    canvas.height = 128;
    const ctx = canvas.getContext('2d');
    const grad = ctx.createRadialGradient(64, 64, 0, 64, 64, 64);
    grad.addColorStop(0, 'rgba(255, 255, 255, 1)');
    grad.addColorStop(0.2, 'rgba(255, 240, 180, 0.8)');
    grad.addColorStop(0.6, 'rgba(120, 240, 160, 0.25)');
    grad.addColorStop(1, 'rgba(0, 0, 0, 0)');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, 128, 128);
    const texture = new THREE.CanvasTexture(canvas);
    return texture;
  }

  function createMistTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 128;
    canvas.height = 128;
    const ctx = canvas.getContext('2d');
    const grad = ctx.createRadialGradient(64, 64, 4, 64, 64, 60);
    grad.addColorStop(0, 'rgba(255, 255, 255, 0.7)');
    grad.addColorStop(0.4, 'rgba(230, 245, 255, 0.35)');
    grad.addColorStop(0.8, 'rgba(200, 240, 245, 0.08)');
    grad.addColorStop(1, 'rgba(255, 255, 255, 0)');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, 128, 128);
    const texture = new THREE.CanvasTexture(canvas);
    return texture;
  }

  function createBarkTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 256;
    canvas.height = 256;
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#2d1e12';
    ctx.fillRect(0, 0, 256, 256);
    for (let x = 0; x < 256; x += 4) {
      const v = Math.sin(x * 0.1) * 20 + Math.random() * 25;
      ctx.fillStyle = `rgb(${45 + v * 0.4}, ${30 + v * 0.3}, ${18 + v * 0.2})`;
      ctx.fillRect(x, 0, 3 + Math.random() * 2, 256);
    }
    // Moss stains
    for (let i = 0; i < 40; i++) {
      const rx = Math.random() * 256, ry = Math.random() * 256;
      ctx.fillStyle = 'rgba(40, 85, 35, 0.25)';
      ctx.beginPath();
      ctx.arc(rx, ry, 6 + Math.random() * 14, 0, Math.PI * 2);
      ctx.fill();
    }
    const texture = new THREE.CanvasTexture(canvas);
    texture.wrapS = THREE.RepeatWrapping;
    texture.wrapT = THREE.RepeatWrapping;
    return texture;
  }

  function createLeafTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 128;
    canvas.height = 128;
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, 128, 128);

    // Oval leaf shape with point
    ctx.save();
    ctx.translate(64, 64);
    ctx.beginPath();
    ctx.moveTo(0, -56);
    ctx.bezierCurveTo(45, -30, 48, 30, 0, 56);
    ctx.bezierCurveTo(-48, 30, -45, -30, 0, -56);
    ctx.closePath();

    const grad = ctx.createLinearGradient(0, -56, 0, 56);
    grad.addColorStop(0, '#58a846');
    grad.addColorStop(0.5, '#2f7a26');
    grad.addColorStop(1, '#1b5219');
    ctx.fillStyle = grad;
    ctx.fill();

    // Central vein
    ctx.strokeStyle = '#7ecc5e';
    ctx.lineWidth = 2.5;
    ctx.beginPath();
    ctx.moveTo(0, -50);
    ctx.lineTo(0, 50);
    ctx.stroke();

    // Subtle side veins
    ctx.lineWidth = 1;
    ctx.strokeStyle = 'rgba(126, 204, 94, 0.45)';
    for (let y = -35; y < 40; y += 14) {
      ctx.beginPath();
      ctx.moveTo(0, y);
      ctx.lineTo(24, y - 8);
      ctx.moveTo(0, y);
      ctx.lineTo(-24, y - 8);
      ctx.stroke();
    }
    ctx.restore();

    const texture = new THREE.CanvasTexture(canvas);
    return texture;
  }

  function createWaterNormalCanvas() {
    const canvas = document.createElement('canvas');
    canvas.width = 256;
    canvas.height = 256;
    const ctx = canvas.getContext('2d');
    const imgData = ctx.createImageData(256, 256);
    const data = imgData.data;

    for (let y = 0; y < 256; y++) {
      for (let x = 0; x < 256; x++) {
        const u = x / 256;
        const v = y / 256;
        const n1 = Simplex.noise2D(u * 8, v * 8);
        const n2 = Simplex.noise2D(u * 16, v * 16) * 0.5;
        const n = (n1 + n2) * 0.5;
        const nx = Math.floor((n * 0.5 + 0.5) * 255);
        const ny = Math.floor(((Simplex.noise2D(u * 8 + 5.2, v * 8 + 1.3)) * 0.5 + 0.5) * 255);
        const idx = (y * 256 + x) * 4;
        data[idx] = nx;        // R -> Normal X
        data[idx + 1] = ny;    // G -> Normal Y
        data[idx + 2] = 230;   // B -> Normal Z
        data[idx + 3] = 255;
      }
    }
    ctx.putImageData(imgData, 0, 0);
    const texture = new THREE.CanvasTexture(canvas);
    texture.wrapS = THREE.RepeatWrapping;
    texture.wrapT = THREE.RepeatWrapping;
    return texture;
  }

  // --- Main NatureBackground3D Class ---
  class NatureBackground {
    constructor(options = {}) {
      this.options = Object.assign({
        container: document.body,
        preset: 'morning', // 'morning', 'noon', 'sunset', 'night'
        windSpeed: 1.0,
        enableAudio: false,
        cameraParallax: true,
        cinematicFlight: true,
        enableControls: true,
        quality: 'high',
        interactive: true
      }, options);

      this.container = typeof this.options.container === 'string'
        ? document.querySelector(this.options.container)
        : this.options.container;

      this.clock = new THREE.Clock();
      this.mouse = { x: 0, y: 0, targetX: 0, targetY: 0 };
      this.listeners = [];
      this.animatedObjects = [];
      this.presets = {
        morning: {
          skyTop: 0x5a9bd6,
          skyBottom: 0xc8e6c9,
          fogColor: 0x86b3a0,
          fogDensity: 0.013,
          sunColor: 0xfff6cf,
          sunIntensity: 1.45,
          sunPos: [35, 45, -60],
          ambientColor: 0x3b664d,
          ambientIntensity: 0.8,
          waterColor: 0x1d5854,
          glowColor: 0xaef7b7
        },
        noon: {
          skyTop: 0x367fca,
          skyBottom: 0x8bd4e2,
          fogColor: 0x629c8e,
          fogDensity: 0.010,
          sunColor: 0xffffff,
          sunIntensity: 1.7,
          sunPos: [10, 65, -30],
          ambientColor: 0x48705c,
          ambientIntensity: 0.95,
          waterColor: 0x15726e,
          glowColor: 0xffe28a
        },
        sunset: {
          skyTop: 0x371b58,
          skyBottom: 0xec7242,
          fogColor: 0x7a3c48,
          fogDensity: 0.014,
          sunColor: 0xff8c42,
          sunIntensity: 1.8,
          sunPos: [60, 20, -70],
          ambientColor: 0x472836,
          ambientIntensity: 0.7,
          waterColor: 0x422030,
          glowColor: 0xffaa54
        },
        night: {
          skyTop: 0x070c18,
          skyBottom: 0x112130,
          fogColor: 0x09141c,
          fogDensity: 0.018,
          sunColor: 0x88c0ff,
          sunIntensity: 0.5,
          sunPos: [-30, 45, -50],
          ambientColor: 0x081720,
          ambientIntensity: 0.4,
          waterColor: 0x09222b,
          glowColor: 0x45ffbc
        }
      };

      this.currentPreset = this.options.preset;
      this.init();
    }

    init() {
      // 1. Scene & Camera Setup
      this.scene = new THREE.Scene();
      const current = this.presets[this.currentPreset];
      this.scene.fog = new THREE.FogExp2(current.fogColor, current.fogDensity);

      const width = this.container.clientWidth || window.innerWidth;
      const height = this.container.clientHeight || window.innerHeight;
      this.camera = new THREE.PerspectiveCamera(52, width / height, 0.1, 800);
      this.camera.position.set(0, 5.2, 18);
      this.cameraTarget = new THREE.Vector3(0, 4.5, -15);
      this.camera.lookAt(this.cameraTarget);

      // 2. WebGL Renderer
      this.renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: false,
        powerPreference: 'high-performance'
      });
      this.renderer.setSize(width, height);
      this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
      this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
      this.renderer.toneMappingExposure = 1.15;
      this.renderer.shadowMap.enabled = true;
      this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;

      // Styling wrapper canvas
      const canvas = this.renderer.domElement;
      canvas.className = 'nature-3d-canvas';
      canvas.style.position = 'absolute';
      canvas.style.top = '0';
      canvas.style.left = '0';
      canvas.style.width = '100%';
      canvas.style.height = '100%';
      canvas.style.zIndex = '0';
      canvas.style.pointerEvents = 'none';

      // Ensure container has relative/absolute positioning
      const containerPos = window.getComputedStyle(this.container).position;
      if (containerPos === 'static') {
        this.container.style.position = 'relative';
      }
      this.container.appendChild(canvas);

      // Shared textures
      this.barkTex = createBarkTexture();
      this.leafTex = createLeafTexture();
      this.glowTex = createGlowTexture();
      this.mistTex = createMistTexture();
      this.waterNormalTex = createWaterNormalCanvas();

      // 3. Build Scene Elements
      this.buildAtmosphere();
      this.buildLighting();
      this.buildMountains();
      this.buildTerrain();
      this.buildRiver();
      this.buildWaterfall();
      this.buildVegetation();
      this.buildSunbeams();
      this.buildFloatingParticles();
      this.buildFireflies();

      // 4. Interaction & Resize Listeners
      this.bindEvents();

      // 5. Start Render Loop
      this.animate = this.animate.bind(this);
      this.animationFrameId = requestAnimationFrame(this.animate);
    }

    // --- Dynamic Atmosphere & Sky Dome ---
    buildAtmosphere() {
      const vertexShader = `
        varying vec3 vWorldPosition;
        void main() {
          vec4 worldPosition = modelMatrix * vec4(position, 1.0);
          vWorldPosition = worldPosition.xyz;
          gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
        }
      `;
      const fragmentShader = `
        uniform vec3 topColor;
        uniform vec3 bottomColor;
        uniform float offset;
        uniform float exponent;
        varying vec3 vWorldPosition;
        void main() {
          float h = normalize(vWorldPosition + offset).y;
          gl_FragColor = vec4(mix(bottomColor, topColor, max(pow(max(h, 0.0), exponent), 0.0)), 1.0);
        }
      `;
      const cur = this.presets[this.currentPreset];
      this.skyUniforms = {
        topColor: { value: new THREE.Color(cur.skyTop) },
        bottomColor: { value: new THREE.Color(cur.skyBottom) },
        offset: { value: 15 },
        exponent: { value: 0.6 }
      };

      const skyGeo = new THREE.SphereGeometry(450, 32, 20);
      const skyMat = new THREE.ShaderMaterial({
        vertexShader,
        fragmentShader,
        uniforms: this.skyUniforms,
        side: THREE.BackSide,
        depthWrite: false
      });
      this.skyMesh = new THREE.Mesh(skyGeo, skyMat);
      this.scene.add(this.skyMesh);

      // Moving atmospheric cloud layers
      this.clouds = [];
      const cloudGeo = new THREE.PlaneGeometry(120, 60);
      const cloudMat = new THREE.MeshBasicMaterial({
        map: this.mistTex,
        transparent: true,
        opacity: 0.22,
        depthWrite: false,
        blending: THREE.AdditiveBlending,
        color: 0xffffff
      });

      for (let i = 0; i < 7; i++) {
        const cloud = new THREE.Mesh(cloudGeo, cloudMat);
        cloud.position.set(-150 + i * 50, 40 + Math.random() * 25, -120 - Math.random() * 80);
        cloud.rotation.x = -0.1;
        cloud.scale.set(1 + Math.random() * 0.8, 0.8 + Math.random() * 0.5, 1);
        cloud.userData.speed = 0.4 + Math.random() * 0.4;
        this.scene.add(cloud);
        this.clouds.push(cloud);
      }
    }

    // --- Dynamic Lighting Setup ---
    buildLighting() {
      const cur = this.presets[this.currentPreset];

      // Ambient Light
      this.ambientLight = new THREE.AmbientLight(cur.ambientColor, cur.ambientIntensity);
      this.scene.add(this.ambientLight);

      // Directional Sun / Moon
      this.sunLight = new THREE.DirectionalLight(cur.sunColor, cur.sunIntensity);
      this.sunLight.position.set(cur.sunPos[0], cur.sunPos[1], cur.sunPos[2]);
      this.sunLight.castShadow = true;
      this.sunLight.shadow.mapSize.width = 2048;
      this.sunLight.shadow.mapSize.height = 2048;
      this.sunLight.shadow.camera.near = 0.5;
      this.sunLight.shadow.camera.far = 180;
      const d = 35;
      this.sunLight.shadow.camera.left = -d;
      this.sunLight.shadow.camera.right = d;
      this.sunLight.shadow.camera.top = d;
      this.sunLight.shadow.camera.bottom = -d;
      this.sunLight.shadow.bias = -0.0008;
      this.scene.add(this.sunLight);

      // Soft water reflection bounce light
      this.waterBounce = new THREE.PointLight(cur.waterColor, 1.2, 35);
      this.waterBounce.position.set(0, 1.5, -4);
      this.scene.add(this.waterBounce);

      // Forest Canopy Rim light
      this.rimLight = new THREE.DirectionalLight(cur.glowColor, 0.4);
      this.rimLight.position.set(-20, 25, 30);
      this.scene.add(this.rimLight);
    }

    // --- Layered Mountains & Ridges (Depth & Immersion) ---
    buildMountains() {
      const layers = [
        { z: -180, scale: 28, y: 35, color: 0x1d3630, segments: 48, oct: 3 },
        { z: -120, scale: 22, y: 22, color: 0x1f4233, segments: 40, oct: 4 },
        { z: -70, scale: 14, y: 12, color: 0x224d35, segments: 32, oct: 4 }
      ];

      layers.forEach((l) => {
        const geo = new THREE.PlaneGeometry(320, 90, l.segments, 24);
        const pos = geo.attributes.position;
        for (let i = 0; i < pos.count; i++) {
          const x = pos.getX(i);
          const y = pos.getY(i);
          if (y > -35) {
            const h = Math.abs(Simplex.fbm(x * 0.015, y * 0.02, l.oct)) * l.scale;
            pos.setZ(i, h);
          }
        }
        geo.computeVertexNormals();

        const mat = new THREE.MeshLambertMaterial({
          color: l.color,
          flatShading: true,
          side: THREE.DoubleSide
        });

        const mountain = new THREE.Mesh(geo, mat);
        mountain.position.set(0, l.y, l.z);
        mountain.rotation.x = -Math.PI / 2 + 0.15;
        this.scene.add(mountain);
      });
    }

    // --- Foreground & River Valley Terrain ---
    buildTerrain() {
      const terrainGeo = new THREE.PlaneGeometry(120, 120, 70, 70);
      terrainGeo.rotateX(-Math.PI / 2);
      const pos = terrainGeo.attributes.position;

      for (let i = 0; i < pos.count; i++) {
        const x = pos.getX(i);
        const z = pos.getZ(i);

        // Valley river canyon carving: River flows roughly around x: sin(z*0.08)*4
        const riverCenter = Math.sin(z * 0.06) * 5.5;
        const distToRiver = Math.abs(x - riverCenter);

        let height = 0;
        if (distToRiver < 5) {
          // River bed depression
          height = -1.2 + (distToRiver / 5) * 1.0;
        } else {
          // Riverbanks and rolling forest hills
          const bankElevation = Math.min((distToRiver - 5) * 0.45, 6.0);
          const noiseHill = Simplex.fbm(x * 0.05, z * 0.05, 3) * 2.8;
          height = bankElevation + noiseHill;
        }

        // Waterfall cliff at z: -28 to -34
        if (z < -26) {
          const cliffFactor = THREE.MathUtils.clamp((-26 - z) * 0.65, 0, 11);
          height += cliffFactor;
        }

        pos.setY(i, height);
      }
      terrainGeo.computeVertexNormals();

      const terrainMat = new THREE.MeshStandardMaterial({
        color: 0x224926,
        roughness: 0.92,
        metalness: 0.08,
        flatShading: true
      });

      this.terrain = new THREE.Mesh(terrainGeo, terrainMat);
      this.terrain.receiveShadow = true;
      this.terrain.castShadow = true;
      this.scene.add(this.terrain);
    }

    // --- Flowing River with Water Reflections & Animated Shader ---
    buildRiver() {
      const riverGeo = new THREE.PlaneGeometry(16, 95, 45, 80);
      riverGeo.rotateX(-Math.PI / 2);

      // Curve river geometry to match valley
      const pos = riverGeo.attributes.position;
      for (let i = 0; i < pos.count; i++) {
        const z = pos.getZ(i);
        const riverCenter = Math.sin(z * 0.06) * 5.5;
        pos.setX(i, pos.getX(i) + riverCenter);
        pos.setY(i, -0.15 + Math.sin(z * 0.12) * 0.05);
      }
      riverGeo.computeVertexNormals();

      // Custom animated water shader for shimmering ripples and crystal reflections
      const cur = this.presets[this.currentPreset];
      const waterUniforms = {
        uTime: { value: 0 },
        uDeepColor: { value: new THREE.Color(cur.waterColor) },
        uSurfaceColor: { value: new THREE.Color(0x3bd4ae) },
        uNormalMap: { value: this.waterNormalTex },
        uSunDirection: { value: new THREE.Vector3(0.5, 1.0, -0.6).normalize() },
        uOpacity: { value: 0.88 }
      };

      const waterVertexShader = `
        uniform float uTime;
        varying vec2 vUv;
        varying vec3 vWorldPos;
        varying vec3 vNormal;

        void main() {
          vUv = uv;
          vec3 transformed = position;
          // Fluid gentle surface waves
          float wave1 = sin(transformed.z * 0.6 + uTime * 2.2) * 0.08;
          float wave2 = cos(transformed.x * 1.2 + uTime * 1.5) * 0.05;
          transformed.y += wave1 + wave2;

          vWorldPos = (modelMatrix * vec4(transformed, 1.0)).xyz;
          vNormal = normalize(normalMatrix * normal);
          gl_Position = projectionMatrix * modelViewMatrix * vec4(transformed, 1.0);
        }
      `;

      const waterFragmentShader = `
        uniform float uTime;
        uniform vec3 uDeepColor;
        uniform vec3 uSurfaceColor;
        uniform sampler2D uNormalMap;
        uniform vec3 uSunDirection;
        uniform float uOpacity;
        varying vec2 vUv;
        varying vec3 vWorldPos;
        varying vec3 vNormal;

        void main() {
          // Flowing normal ripples
          vec2 flowUv1 = vUv * vec2(3.0, 12.0) + vec2(0.0, uTime * 0.28);
          vec2 flowUv2 = vUv * vec2(4.5, 16.0) - vec2(uTime * 0.08, uTime * 0.35);
          vec3 n1 = texture2D(uNormalMap, flowUv1).rgb * 2.0 - 1.0;
          vec3 n2 = texture2D(uNormalMap, flowUv2).rgb * 2.0 - 1.0;
          vec3 perturbedNormal = normalize(vNormal + (n1 + n2) * 0.35);

          // Specular sunlight glint
          vec3 viewDir = normalize(cameraPosition - vWorldPos);
          vec3 reflectDir = reflect(-uSunDirection, perturbedNormal);
          float spec = pow(max(dot(viewDir, reflectDir), 0.0), 38.0);

          // Fresnel reflectance
          float fresnel = pow(1.0 - max(dot(viewDir, perturbedNormal), 0.0), 3.0);
          vec3 waterCol = mix(uDeepColor, uSurfaceColor, fresnel * 0.7 + spec * 0.3);
          waterCol += vec3(1.0, 0.98, 0.9) * spec * 0.9;

          gl_FragColor = vec4(waterCol, uOpacity);
        }
      `;

      this.waterMaterial = new THREE.ShaderMaterial({
        vertexShader: waterVertexShader,
        fragmentShader: waterFragmentShader,
        uniforms: waterUniforms,
        transparent: true,
        depthWrite: false
      });

      this.river = new THREE.Mesh(riverGeo, this.waterMaterial);
      this.river.position.set(0, 0, 0);
      this.scene.add(this.river);

      // Riverbank decorative boulders & stones
      this.buildRiverbankRocks();
    }

    // --- Small Cascading Waterfall Between Rocks ---
    buildWaterfall() {
      // Cliff rocks structure at waterfall location (z: -27 to -32)
      const rockGroup = new THREE.Group();
      const rockGeo = new THREE.DodecahedronGeometry(2.4, 1);
      const rockMat = new THREE.MeshStandardMaterial({
        color: 0x3e403d,
        roughness: 0.85,
        metalness: 0.15,
        flatShading: true
      });

      const rockCoords = [
        [-5.5, 3.8, -28, 1.8],
        [-3.2, 5.0, -30, 2.2],
        [3.8, 4.5, -29, 2.0],
        [5.8, 3.2, -27, 1.7],
        [0.0, 6.2, -32, 2.6]
      ];

      rockCoords.forEach(([x, y, z, s]) => {
        const r = new THREE.Mesh(rockGeo, rockMat);
        r.position.set(x, y, z);
        r.scale.set(s, s * 1.3, s);
        r.rotation.set(Math.random() * 2, Math.random() * 2, Math.random() * 2);
        r.castShadow = true;
        r.receiveShadow = true;
        rockGroup.add(r);
      });
      this.scene.add(rockGroup);

      // Cascading Vertical Water Ribbon
      const fallGeo = new THREE.PlaneGeometry(4.2, 8.5, 16, 28);
      const fallUniforms = {
        uTime: { value: 0 },
        uColor: { value: new THREE.Color(0xd7f7f0) },
        uFoamColor: { value: new THREE.Color(0xffffff) }
      };

      const fallVert = `
        uniform float uTime;
        varying vec2 vUv;
        void main() {
          vUv = uv;
          vec3 p = position;
          // Organic curved cascade
          p.z += sin(p.y * 0.45) * 0.65;
          p.x += sin(p.y * 1.2 + uTime * 3.0) * 0.15;
          gl_Position = projectionMatrix * modelViewMatrix * vec4(p, 1.0);
        }
      `;

      const fallFrag = `
        uniform float uTime;
        uniform vec3 uColor;
        uniform vec3 uFoamColor;
        varying vec2 vUv;
        void main() {
          // Fast downward rush
          float stream = sin(vUv.x * 24.0 + sin(vUv.y * 32.0 - uTime * 9.0) * 2.0);
          float foam = step(0.15, stream);
          vec3 col = mix(uColor, uFoamColor, foam * 0.75 + (1.0 - vUv.y) * 0.25);
          float alpha = 0.82 - vUv.y * 0.15;
          gl_FragColor = vec4(col, alpha);
        }
      `;

      this.waterfallMat = new THREE.ShaderMaterial({
        vertexShader: fallVert,
        fragmentShader: fallFrag,
        uniforms: fallUniforms,
        transparent: true,
        side: THREE.DoubleSide
      });

      this.waterfall = new THREE.Mesh(fallGeo, this.waterfallMat);
      this.waterfall.position.set(-1.0, 2.9, -29);
      this.waterfall.rotation.y = 0.2;
      this.scene.add(this.waterfall);

      // Waterfall Mist & Splash Base System
      const mistCount = 45;
      const mistGeo = new THREE.BufferGeometry();
      const mistPos = new Float32Array(mistCount * 3);
      const mistScale = new Float32Array(mistCount);
      this.mistInitial = [];

      for (let i = 0; i < mistCount; i++) {
        const x = -1.0 + (Math.random() - 0.5) * 5.0;
        const y = -0.2 + Math.random() * 2.5;
        const z = -28.5 + (Math.random() - 0.5) * 3.5;
        mistPos[i * 3] = x;
        mistPos[i * 3 + 1] = y;
        mistPos[i * 3 + 2] = z;
        mistScale[i] = 1.8 + Math.random() * 2.2;
        this.mistInitial.push({ x, y, z, vy: 0.015 + Math.random() * 0.02, vx: (Math.random() - 0.5) * 0.01 });
      }

      mistGeo.setAttribute('position', new THREE.BufferAttribute(mistPos, 3));
      mistGeo.setAttribute('scale', new THREE.BufferAttribute(mistScale, 1));

      const mistMat = new THREE.PointsMaterial({
        size: 3.2,
        map: this.mistTex,
        transparent: true,
        opacity: 0.35,
        depthWrite: false,
        blending: THREE.AdditiveBlending,
        color: 0xdbf9f2
      });

      this.waterfallMist = new THREE.Points(mistGeo, mistMat);
      this.scene.add(this.waterfallMist);
    }

    // --- Riverbank Mossy Rocks & Boulders ---
    buildRiverbankRocks() {
      const rockGeo = new THREE.DodecahedronGeometry(1.2, 1);
      const rockMat = new THREE.MeshStandardMaterial({
        color: 0x414b43,
        roughness: 0.88,
        metalness: 0.1,
        flatShading: true
      });

      const rockCount = 28;
      this.rockInstanced = new THREE.InstancedMesh(rockGeo, rockMat, rockCount);
      const dummy = new THREE.Object3D();

      for (let i = 0; i < rockCount; i++) {
        const side = i % 2 === 0 ? 1 : -1;
        const z = -35 + Math.random() * 55;
        const riverCenter = Math.sin(z * 0.06) * 5.5;
        const x = riverCenter + side * (3.8 + Math.random() * 3.5);
        const y = -0.2 + Math.random() * 0.6;
        const scale = 0.5 + Math.random() * 1.3;

        dummy.position.set(x, y, z);
        dummy.scale.set(scale, scale * (0.6 + Math.random() * 0.8), scale);
        dummy.rotation.set(Math.random() * 3, Math.random() * 3, Math.random() * 3);
        dummy.updateMatrix();
        this.rockInstanced.setMatrixAt(i, dummy.matrix);
      }
      this.rockInstanced.castShadow = true;
      this.rockInstanced.receiveShadow = true;
      this.scene.add(this.rockInstanced);
    }

    // --- Lush 3D Trees with Gentle Wind Swaying & Exotic Foliage ---
    buildVegetation() {
      this.trees = [];

      // Procedural Tree Generation helper
      const createTree = (posX, posZ, scale = 1, type = 'tropical') => {
        const treeGroup = new THREE.Group();
        treeGroup.position.set(posX, 0, posZ);

        // Calculate ground height at tree base
        const riverCenter = Math.sin(posZ * 0.06) * 5.5;
        const dist = Math.abs(posX - riverCenter);
        const groundY = Math.max(0, (dist - 5) * 0.45) + (posZ < -26 ? THREE.MathUtils.clamp((-26 - posZ) * 0.65, 0, 11) : 0);
        treeGroup.position.y = groundY;

        // Trunk
        const trunkHeight = 6.5 * scale;
        const trunkGeo = new THREE.CylinderGeometry(0.25 * scale, 0.55 * scale, trunkHeight, 7, 5);
        // Slightly curve trunk vertices
        const tpos = trunkGeo.attributes.position;
        for (let j = 0; j < tpos.count; j++) {
          const ty = tpos.getY(j);
          if (ty > 0) {
            tpos.setX(j, tpos.getX(j) + Math.sin(ty * 0.4) * 0.3 * scale);
          }
        }
        trunkGeo.computeVertexNormals();

        const trunkMat = new THREE.MeshStandardMaterial({
          map: this.barkTex,
          roughness: 0.9,
          metalness: 0.1
        });
        const trunk = new THREE.Mesh(trunkGeo, trunkMat);
        trunk.position.y = trunkHeight / 2;
        trunk.castShadow = true;
        trunk.receiveShadow = true;
        treeGroup.add(trunk);

        // Canopy Leaf Clusters
        const canopyGroup = new THREE.Group();
        canopyGroup.position.y = trunkHeight * 0.85;

        const leafCount = type === 'tropical' ? 7 : 5;
        const leafMat = new THREE.MeshStandardMaterial({
          map: this.leafTex,
          transparent: true,
          alphaTest: 0.12,
          side: THREE.DoubleSide,
          roughness: 0.65
        });

        for (let l = 0; l < leafCount; l++) {
          const clusterSize = (3.2 + Math.random() * 1.8) * scale;
          const clusterGeo = new THREE.DodecahedronGeometry(clusterSize, 1);
          // Shade variations
          const shadeOffset = (Math.random() - 0.5) * 0.15;
          const cMat = leafMat.clone();
          cMat.color.setHSL(0.31 + shadeOffset * 0.1, 0.65, 0.32 + shadeOffset);

          const cluster = new THREE.Mesh(clusterGeo, cMat);
          const angle = (l / leafCount) * Math.PI * 2;
          const distFromTrunk = (1.4 + Math.random() * 1.2) * scale;
          cluster.position.set(
            Math.cos(angle) * distFromTrunk,
            (Math.random() * 2.2 - 0.5) * scale,
            Math.sin(angle) * distFromTrunk
          );
          cluster.rotation.set(Math.random() * 0.5, angle, Math.random() * 0.5);
          cluster.castShadow = true;
          cluster.receiveShadow = true;
          cluster.userData = {
            baseRotationX: cluster.rotation.x,
            baseRotationZ: cluster.rotation.z,
            phase: Math.random() * Math.PI * 2
          };
          canopyGroup.add(cluster);
        }

        treeGroup.add(canopyGroup);
        treeGroup.userData = {
          canopy: canopyGroup,
          baseRotationZ: 0,
          windPhase: Math.random() * Math.PI * 2,
          swayFactor: (0.045 / scale)
        };

        this.scene.add(treeGroup);
        this.trees.push(treeGroup);
      };

      // Populate forest along left and right banks
      const treePlacements = [
        // Left dense forest
        [-9, 12, 1.2], [-14, 8, 1.4], [-8, 2, 1.1], [-16, -4, 1.5],
        [-11, -12, 1.3], [-18, -18, 1.6], [-8, -20, 1.0], [-13, -26, 1.3],
        [-19, -32, 1.7], [-7, -35, 1.2],
        // Right dense forest
        [10, 10, 1.2], [15, 6, 1.4], [9, -1, 1.0], [17, -8, 1.6],
        [12, -15, 1.3], [19, -21, 1.5], [8, -24, 1.1], [14, -29, 1.4],
        [20, -35, 1.6], [10, -38, 1.2],
        // Distant depth trees
        [-24, -45, 2.0], [25, -48, 2.1], [-5, -42, 1.3], [4, -44, 1.2]
      ];

      treePlacements.forEach(([x, z, s]) => {
        createTree(x, z, s);
      });

      // Ground Understory: Ferns & Glowing Tropical Flowers
      this.buildUnderstoryVegetation();
    }

    // --- Ferns, Swaying Grass Blades & Bioluminescent Flowers ---
    buildUnderstoryVegetation() {
      // Instanced Fern / Grass Clumps
      const grassGeo = new THREE.PlaneGeometry(0.8, 1.4);
      grassGeo.translate(0, 0.7, 0);
      const grassMat = new THREE.MeshLambertMaterial({
        map: this.leafTex,
        transparent: true,
        alphaTest: 0.15,
        side: THREE.DoubleSide
      });

      const grassCount = 120;
      this.grassInstanced = new THREE.InstancedMesh(grassGeo, grassMat, grassCount);
      const dummy = new THREE.Object3D();

      for (let i = 0; i < grassCount; i++) {
        const z = -25 + Math.random() * 45;
        const riverCenter = Math.sin(z * 0.06) * 5.5;
        const side = i % 2 === 0 ? 1 : -1;
        const x = riverCenter + side * (3.5 + Math.random() * 8.0);
        const y = Math.max(0, (Math.abs(x - riverCenter) - 5) * 0.45);

        dummy.position.set(x, y, z);
        dummy.scale.set(0.8 + Math.random() * 0.8, 1.0 + Math.random() * 0.9, 0.8 + Math.random() * 0.8);
        dummy.rotation.set(0, Math.random() * Math.PI, (Math.random() - 0.5) * 0.25);
        dummy.updateMatrix();
        this.grassInstanced.setMatrixAt(i, dummy.matrix);
      }
      this.grassInstanced.receiveShadow = true;
      this.scene.add(this.grassInstanced);

      // Glowing Magical Forest Flowers
      const flowerCount = 35;
      const flowerGeo = new THREE.SphereGeometry(0.18, 8, 8);
      const flowerColors = [0x50f7ff, 0xff5493, 0xffdf54, 0x54ff98];

      for (let f = 0; f < flowerCount; f++) {
        const col = flowerColors[f % flowerColors.length];
        const fMat = new THREE.MeshBasicMaterial({ color: col });
        const flower = new THREE.Mesh(flowerGeo, fMat);

        const z = -22 + Math.random() * 38;
        const riverCenter = Math.sin(z * 0.06) * 5.5;
        const side = f % 2 === 0 ? 1 : -1;
        const x = riverCenter + side * (3.8 + Math.random() * 6.5);
        const y = Math.max(0.1, (Math.abs(x - riverCenter) - 5) * 0.45) + 0.2;

        flower.position.set(x, y, z);
        this.scene.add(flower);

        // Flower halo
        const haloMat = new THREE.SpriteMaterial({
          map: this.glowTex,
          color: col,
          transparent: true,
          opacity: 0.65,
          blending: THREE.AdditiveBlending
        });
        const halo = new THREE.Sprite(haloMat);
        halo.scale.set(1.2, 1.2, 1.2);
        flower.add(halo);
      }
    }

    // --- Volumetric Sunlight God Rays Passing Through Canopy ---
    buildSunbeams() {
      this.sunbeams = [];
      const beamGeo = new THREE.CylinderGeometry(0.4, 4.8, 38, 16, 1, true);
      beamGeo.translate(0, 19, 0);

      const beamMat = new THREE.MeshBasicMaterial({
        color: 0xfff9d6,
        transparent: true,
        opacity: 0.16,
        depthWrite: false,
        blending: THREE.AdditiveBlending,
        side: THREE.DoubleSide
      });

      const beamPositions = [
        [-6, 3, -15, 0.22, 0.4],
        [5, 4, -18, -0.18, 0.35],
        [-2, 6, -26, 0.15, 0.28],
        [8, 2, -8, -0.25, 0.45],
        [-11, 5, -5, 0.3, 0.32]
      ];

      beamPositions.forEach(([x, y, z, rotZ, rotX]) => {
        const beam = new THREE.Mesh(beamGeo, beamMat);
        beam.position.set(x, y, z);
        beam.rotation.set(rotX, 0, rotZ);
        beam.userData = {
          baseOpacity: 0.14 + Math.random() * 0.06,
          pulseSpeed: 0.5 + Math.random() * 0.6,
          pulsePhase: Math.random() * Math.PI * 2
        };
        this.scene.add(beam);
        this.sunbeams.push(beam);
      });
    }

    // --- Floating Pollen / Dust Motes Caught in Sunlight ---
    buildFloatingParticles() {
      const pCount = 280;
      const pGeo = new THREE.BufferGeometry();
      const pPos = new Float32Array(pCount * 3);
      this.pVelocity = [];

      for (let i = 0; i < pCount; i++) {
        pPos[i * 3] = (Math.random() - 0.5) * 45;
        pPos[i * 3 + 1] = 0.5 + Math.random() * 16;
        pPos[i * 3 + 2] = -35 + Math.random() * 55;
        this.pVelocity.push({
          x: (Math.random() - 0.5) * 0.012,
          y: -0.003 - Math.random() * 0.006,
          z: (Math.random() - 0.5) * 0.012,
          phase: Math.random() * Math.PI * 2
        });
      }

      pGeo.setAttribute('position', new THREE.BufferAttribute(pPos, 3));
      const pMat = new THREE.PointsMaterial({
        size: 0.55,
        map: this.glowTex,
        transparent: true,
        opacity: 0.75,
        depthWrite: false,
        blending: THREE.AdditiveBlending,
        color: 0xfff6cf
      });

      this.particles = new THREE.Points(pGeo, pMat);
      this.scene.add(this.particles);
    }

    // --- Bioluminescent Fireflies with Natural Pulsing & Flight ---
    buildFireflies() {
      this.fireflies = [];
      const ffGroup = new THREE.Group();

      const ffCount = 38;
      const cur = this.presets[this.currentPreset];

      for (let i = 0; i < ffCount; i++) {
        const spriteMat = new THREE.SpriteMaterial({
          map: this.glowTex,
          color: cur.glowColor,
          transparent: true,
          opacity: 0.85,
          blending: THREE.AdditiveBlending
        });
        const sprite = new THREE.Sprite(spriteMat);
        const s = 0.75 + Math.random() * 0.6;
        sprite.scale.set(s, s, 1);

        const initialX = (Math.random() - 0.5) * 26;
        const initialY = 1.0 + Math.random() * 5.0;
        const initialZ = -28 + Math.random() * 42;
        sprite.position.set(initialX, initialY, initialZ);

        sprite.userData = {
          baseX: initialX,
          baseY: initialY,
          baseZ: initialZ,
          rangeX: 1.5 + Math.random() * 2.5,
          rangeY: 0.8 + Math.random() * 1.5,
          rangeZ: 1.5 + Math.random() * 2.5,
          speed: 0.8 + Math.random() * 1.2,
          pulseSpeed: 2.0 + Math.random() * 3.0,
          phase: Math.random() * Math.PI * 2
        };

        ffGroup.add(sprite);
        this.fireflies.push(sprite);
      }

      this.scene.add(ffGroup);
    }

    // --- Event Listeners & Interaction ---
    bindEvents() {
      this.onResize = () => {
        const width = this.container.clientWidth || window.innerWidth;
        const height = this.container.clientHeight || window.innerHeight;
        this.camera.aspect = width / height;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(width, height);
      };
      window.addEventListener('resize', this.onResize);

      // Smooth Mouse Tracking
      this.onMouseMove = (e) => {
        if (!this.options.interactive) return;
        const normX = (e.clientX / window.innerWidth) * 2 - 1;
        const normY = -(e.clientY / window.innerHeight) * 2 + 1;
        this.mouse.targetX = normX;
        this.mouse.targetY = normY;
      };
      window.addEventListener('mousemove', this.onMouseMove);

      // Device Gyroscope Support for Mobile Parallax
      this.onDeviceOrientation = (e) => {
        if (!this.options.interactive || !e.gamma) return;
        this.mouse.targetX = THREE.MathUtils.clamp(e.gamma / 30, -1, 1);
        this.mouse.targetY = THREE.MathUtils.clamp(e.beta / 30, -1, 1);
      };
      window.addEventListener('deviceorientation', this.onDeviceOrientation);
    }

    // --- Preset Switcher (Time of Day & Atmosphere) ---
    setPreset(name) {
      if (!this.presets[name]) return;
      this.currentPreset = name;
      const cur = this.presets[name];

      // Smoothly update fog
      this.scene.fog.color.set(cur.fogColor);
      this.scene.fog.density = cur.fogDensity;

      // Update Sky uniforms
      this.skyUniforms.topColor.value.set(cur.skyTop);
      this.skyUniforms.bottomColor.value.set(cur.skyBottom);

      // Update Lights
      this.ambientLight.color.set(cur.ambientColor);
      this.ambientLight.intensity = cur.ambientIntensity;
      this.sunLight.color.set(cur.sunColor);
      this.sunLight.intensity = cur.sunIntensity;
      this.sunLight.position.set(cur.sunPos[0], cur.sunPos[1], cur.sunPos[2]);
      this.waterBounce.color.set(cur.waterColor);
      this.rimLight.color.set(cur.glowColor);

      // Update Water shader
      if (this.waterMaterial) {
        this.waterMaterial.uniforms.uDeepColor.value.set(cur.waterColor);
      }

      // Update Fireflies glow color
      this.fireflies.forEach(ff => {
        ff.material.color.set(cur.glowColor);
      });
    }

    setWindSpeed(val) {
      this.options.windSpeed = THREE.MathUtils.clamp(val, 0, 3.5);
    }

    setCinematicFlight(enable) {
      this.options.cinematicFlight = !!enable;
    }

    // --- Ambient Web Audio Synthesizer (Zero Assets Needed) ---
    toggleAudio(forceState) {
      const state = forceState !== undefined ? forceState : !this.audioPlaying;
      if (state) {
        this.startNatureAudio();
      } else {
        this.stopNatureAudio();
      }
      return this.audioPlaying;
    }

    startNatureAudio() {
      if (this.audioCtx) {
        if (this.audioCtx.state === 'suspended') this.audioCtx.resume();
        this.audioPlaying = true;
        return;
      }

      const AudioCtx = window.AudioContext || window.webkitAudioContext;
      if (!AudioCtx) return;
      this.audioCtx = new AudioCtx();

      // Pink noise river audio synthesis
      const bufferSize = this.audioCtx.sampleRate * 2;
      const noiseBuffer = this.audioCtx.createBuffer(1, bufferSize, this.audioCtx.sampleRate);
      const output = noiseBuffer.getChannelData(0);
      let b0 = 0, b1 = 0, b2 = 0, b3 = 0, b4 = 0, b5 = 0, b6 = 0;
      for (let i = 0; i < bufferSize; i++) {
        const white = Math.random() * 2 - 1;
        b0 = 0.99886 * b0 + white * 0.0555179;
        b1 = 0.99332 * b1 + white * 0.0750759;
        b2 = 0.96900 * b2 + white * 0.1538520;
        b3 = 0.86650 * b3 + white * 0.3104856;
        b4 = 0.55000 * b4 + white * 0.5329522;
        b5 = -0.7616 * b5 - white * 0.0168980;
        output[i] = (b0 + b1 + b2 + b3 + b4 + b5 + b6 + white * 0.5362) * 0.04;
        b6 = white * 0.115926;
      }

      const whiteNoise = this.audioCtx.createBufferSource();
      whiteNoise.buffer = noiseBuffer;
      whiteNoise.loop = true;

      const riverFilter = this.audioCtx.createBiquadFilter();
      riverFilter.type = 'lowpass';
      riverFilter.frequency.setValueAtTime(450, this.audioCtx.currentTime);

      this.riverGain = this.audioCtx.createGain();
      this.riverGain.gain.setValueAtTime(0.35, this.audioCtx.currentTime);

      whiteNoise.connect(riverFilter);
      riverFilter.connect(this.riverGain);
      this.riverGain.connect(this.audioCtx.destination);
      whiteNoise.start();

      this.audioPlaying = true;
    }

    stopNatureAudio() {
      if (this.audioCtx && this.audioCtx.state === 'running') {
        this.audioCtx.suspend();
      }
      this.audioPlaying = false;
    }

    // --- Main Animation & Render Loop ---
    animate() {
      this.animationFrameId = requestAnimationFrame(this.animate);

      const delta = this.clock.getDelta();
      const elapsedTime = this.clock.getElapsedTime();
      const wind = this.options.windSpeed;

      // 1. Smooth Mouse Parallax Interpolation
      this.mouse.x += (this.mouse.targetX - this.mouse.x) * 0.05;
      this.mouse.y += (this.mouse.targetY - this.mouse.y) * 0.05;

      // 2. Cinematic Camera Movement
      if (this.options.cinematicFlight) {
        // Slow organic swooping glide
        const camFlightX = Math.sin(elapsedTime * 0.18) * 4.2;
        const camFlightY = 4.8 + Math.cos(elapsedTime * 0.12) * 1.2;
        const camFlightZ = 16.0 + Math.sin(elapsedTime * 0.15) * 2.8;

        // Apply subtle mouse parallax on top of flight
        const mouseParallaxX = this.options.cameraParallax ? this.mouse.x * 2.2 : 0;
        const mouseParallaxY = this.options.cameraParallax ? this.mouse.y * 1.5 : 0;

        this.camera.position.x = camFlightX + mouseParallaxX;
        this.camera.position.y = camFlightY + mouseParallaxY;
        this.camera.position.z = camFlightZ;

        this.cameraTarget.x = Math.sin(elapsedTime * 0.14) * 2.0 + (this.options.cameraParallax ? this.mouse.x * 1.5 : 0);
        this.cameraTarget.y = 4.0 + (this.options.cameraParallax ? this.mouse.y * 0.8 : 0);
        this.cameraTarget.z = -18.0;
        this.camera.lookAt(this.cameraTarget);
      } else if (this.options.cameraParallax) {
        this.camera.position.x = this.mouse.x * 3.5;
        this.camera.position.y = 5.2 + this.mouse.y * 2.0;
        this.camera.lookAt(this.cameraTarget);
      }

      // 3. Clouds Drifting Across Sky
      this.clouds.forEach(cloud => {
        cloud.position.x += cloud.userData.speed * delta * 2.0;
        if (cloud.position.x > 180) cloud.position.x = -180;
      });

      // 4. River & Waterfall Shader Animation
      if (this.waterMaterial) {
        this.waterMaterial.uniforms.uTime.value = elapsedTime;
      }
      if (this.waterfallMat) {
        this.waterfallMat.uniforms.uTime.value = elapsedTime;
      }

      // 5. Waterfall Mist Particles Rising & Billowing
      if (this.waterfallMist) {
        const posAttr = this.waterfallMist.geometry.attributes.position;
        const count = posAttr.count;
        for (let i = 0; i < count; i++) {
          const init = this.mistInitial[i];
          let y = posAttr.getY(i) + init.vy;
          let x = posAttr.getX(i) + init.vx + Math.sin(elapsedTime * 2 + i) * 0.01;
          if (y > 3.5) {
            y = init.y;
            x = init.x;
          }
          posAttr.setY(i, y);
          posAttr.setX(i, x);
        }
        posAttr.needsUpdate = true;
      }

      // 6. Trees & Canopy Wind Swaying
      this.trees.forEach(tree => {
        const u = tree.userData;
        const sway = Math.sin(elapsedTime * 1.5 * wind + u.windPhase) * u.swayFactor * wind;
        tree.rotation.z = sway;
        tree.rotation.x = Math.cos(elapsedTime * 1.1 * wind + u.windPhase) * (u.swayFactor * 0.6) * wind;

        // Leaf clusters individual flutter
        if (u.canopy && u.canopy.children) {
          u.canopy.children.forEach(cluster => {
            const cU = cluster.userData;
            cluster.rotation.x = cU.baseRotationX + Math.sin(elapsedTime * 3.5 * wind + cU.phase) * 0.08 * wind;
            cluster.rotation.z = cU.baseRotationZ + Math.cos(elapsedTime * 3.0 * wind + cU.phase) * 0.06 * wind;
          });
        }
      });

      // 7. Volumetric Sunbeams Pulsing
      this.sunbeams.forEach(beam => {
        const u = beam.userData;
        beam.material.opacity = u.baseOpacity + Math.sin(elapsedTime * u.pulseSpeed + u.pulsePhase) * 0.04;
      });

      // 8. Floating Dust Motes Motion
      if (this.particles) {
        const pPos = this.particles.geometry.attributes.position;
        const count = pPos.count;
        for (let i = 0; i < count; i++) {
          const v = this.pVelocity[i];
          let px = pPos.getX(i) + v.x + Math.sin(elapsedTime * 0.8 + v.phase) * 0.012;
          let py = pPos.getY(i) + v.y;
          let pz = pPos.getZ(i) + v.z;

          if (py < 0.2) py = 16.0;
          if (px > 25) px = -25;
          if (px < -25) px = 25;

          pPos.setXYZ(i, px, py, pz);
        }
        pPos.needsUpdate = true;
      }

      // 9. Fireflies Dancing & Pulsing
      this.fireflies.forEach(ff => {
        const u = ff.userData;
        const t = elapsedTime * u.speed + u.phase;
        ff.position.x = u.baseX + Math.sin(t * 1.2) * u.rangeX;
        ff.position.y = u.baseY + Math.sin(t * 2.1) * u.rangeY + Math.cos(t * 0.8) * 0.4;
        ff.position.z = u.baseZ + Math.cos(t * 1.4) * u.rangeZ;

        // Pulsating luminescence
        const pulse = Math.sin(elapsedTime * u.pulseSpeed + u.phase);
        ff.material.opacity = 0.35 + Math.max(0, pulse) * 0.65;
      });

      // Render Scene
      this.renderer.render(this.scene, this.camera);
    }

    // --- Cleanup ---
    destroy() {
      if (this.animationFrameId) {
        cancelAnimationFrame(this.animationFrameId);
      }
      window.removeEventListener('resize', this.onResize);
      window.removeEventListener('mousemove', this.onMouseMove);
      window.removeEventListener('deviceorientation', this.onDeviceOrientation);
      this.stopNatureAudio();

      if (this.renderer && this.renderer.domElement && this.renderer.domElement.parentNode) {
        this.renderer.domElement.parentNode.removeChild(this.renderer.domElement);
      }
      this.renderer.dispose();
    }
  }

  return NatureBackground;
});
