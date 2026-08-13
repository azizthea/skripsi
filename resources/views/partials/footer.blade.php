{{-- Al-Furqoniyah Premium Footer --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Source+Sans+3:wght@300;400;500;600&display=swap');
:root{--g:#1a5c38;--g2:#1e6b41;--gold:#c9a44a;--gl:#e0bc6e;--gp:#f4e5b2;--cr:#f6f1e8;--cd:rgba(246,241,232,.6);--cf:rgba(246,241,232,.32);--br:rgba(201,164,74,.22);--ease:cubic-bezier(.25,1,.5,1)}

.pf{background:var(--g);color:var(--cr);font-family:'Source Sans 3',sans-serif;position:relative;overflow:hidden}

/* Paper noise texture */
.pf::before{content:'';position:absolute;inset:0;z-index:0;pointer-events:none;opacity:.055;
background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='f'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23f)'/%3E%3C/svg%3E");
background-size:200px 200px}

/* Ambient lantern glow layer */
.pf-nur{position:absolute;inset:0;z-index:1;pointer-events:none;background:radial-gradient(circle at 50% 50%,rgba(201,164,74,.07) 0%,transparent 55%);transition:background .12s ease}

/* All content above layers */
.pf-inner{position:relative;z-index:2;max-width:1200px;margin:0 auto;padding:0 2.5rem 2.5rem}

/* ── Architectural Mosque Arch Divider ── */
.pf-arch{line-height:0;overflow:hidden}
.pf-arch svg{display:block;width:100%;height:auto}

/* ── Brand + Button Row ── */
.pf-top{display:flex;align-items:center;gap:2rem;padding:2.5rem 0 2rem;border-bottom:1px solid var(--br)}
.pf-seal{flex-shrink:0;width:52px;height:52px;border:1.5px solid rgba(201,164,74,.5);border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(201,164,74,.07)}
.pf-seal svg{width:26px;height:26px}
.pf-btext{flex:1}
.pf-sub{font-size:.68rem;font-weight:500;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);display:block;margin-bottom:.3rem}
.pf-name{font-family:'Playfair Display',serif;font-size:clamp(1.3rem,2.5vw,1.8rem);font-weight:700;letter-spacing:.03em;color:var(--cr);line-height:1}
.pf-name em{color:var(--gold);font-style:normal}
.pf-tag{font-size:.85rem;font-weight:300;color:var(--cd);line-height:1.6;margin-top:.35rem;max-width:400px}

/* ── CTA Button ── */
.pf-btn{flex-shrink:0;display:inline-flex;align-items:center;gap:.55rem;padding:.75rem 1.6rem;background:var(--gold);color:#1a3020;font-size:.82rem;font-weight:600;letter-spacing:.06em;text-decoration:none;border-radius:7px;box-shadow:0 2px 14px rgba(201,164,74,.3);transition:background .22s ease,transform .2s ease,box-shadow .22s ease}
.pf-btn:hover{background:var(--gl);transform:translateY(-2px);box-shadow:0 6px 22px rgba(201,164,74,.42);color:#1a3020}
.pf-btn svg{width:14px;height:14px;transition:transform .22s ease}
.pf-btn:hover svg{transform:translateX(3px)}

/* ── Nav Grid ── */
.pf-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem 2.5rem;padding:2rem 0;border-bottom:1px solid var(--br)}
.pf-col-h{font-size:.66rem;font-weight:600;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);display:block;margin-bottom:1rem}
.pf-links{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:.6rem}
.pf-links a{text-decoration:none;color:var(--cd);font-size:.9rem;font-weight:300;line-height:1.5;display:inline-block;position:relative;padding-left:0;transition:color .2s,padding-left .2s}
.pf-links a::before{content:'—';position:absolute;left:-1.1rem;opacity:0;color:var(--gold);font-size:.7rem;transition:opacity .2s,left .2s}
.pf-links a:hover{color:var(--cr);padding-left:1rem}
.pf-links a:hover::before{opacity:1;left:0}
.pf-ci{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:.85rem}
.pf-ci li{display:flex;align-items:flex-start;gap:.6rem;font-size:.86rem;font-weight:300;color:var(--cd);line-height:1.55}
.pf-ci svg{width:14px;height:14px;color:var(--gold);flex-shrink:0;margin-top:2px}

/* ── Bottom Bar ── */
.pf-bot{display:flex;align-items:flex-start;justify-content:space-between;gap:2rem;padding-top:1.8rem;flex-wrap:wrap}
.pf-verse{display:flex;flex-direction:column;align-items:flex-start;gap:.35rem}
.pf-ar{font-family:'Traditional Arabic','Scheherazade New','Amiri','Noto Naskh Arabic',serif;font-size:1.55rem;direction:rtl;color:var(--gp);line-height:1.9;letter-spacing:.02em;display:block}
.pf-tr{font-family:'Playfair Display',serif;font-style:italic;font-size:.8rem;color:rgba(246,241,232,.55);letter-spacing:.02em}
.pf-ref{font-size:.68rem;color:rgba(201,164,74,.6);letter-spacing:.1em;text-transform:uppercase;margin-top:.1rem}

.pf-right{display:flex;flex-direction:column;align-items:flex-end;gap:1.1rem}
/* Social icons — floating line-art only, no boxes */
.pf-soc{display:flex;align-items:center;gap:1.3rem}
.pf-soc a{display:flex;color:rgba(246,241,232,.4);text-decoration:none;transition:color .22s,transform .22s}
.pf-soc a svg{width:18px;height:18px}
.pf-soc a:hover{color:var(--gold);transform:translateY(-3px)}
.pf-copy{font-size:.71rem;font-weight:400;color:rgba(246,241,232,.45);letter-spacing:.05em;text-align:right;line-height:1.75}
.pf-copy a{color:rgba(246,241,232,.5);text-decoration:none;transition:color .2s}
.pf-copy a:hover{color:var(--gold)}

@media(max-width:900px){
  .pf-inner{padding:0 1.5rem 2rem}
  .pf-top{flex-wrap:wrap}
  .pf-btn{order:3;width:100%}
  .pf-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:580px){
  .pf-grid{grid-template-columns:1fr;gap:1.5rem}
  .pf-bot{flex-direction:column}
  .pf-right{align-items:flex-start}
  .pf-copy{text-align:left}
}
</style>

<footer class="pf" role="contentinfo" aria-label="Footer Al-Furqoniyah" id="pf-footer">
  <div class="pf-nur" id="pf-nur" aria-hidden="true"></div>

  {{-- ── Pointed Islamic Arch Divider ─────────────────────── --}}
  <div class="pf-arch" aria-hidden="true">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      {{-- Background fill of section above --}}
      <rect width="1440" height="80" fill="#e8e2d8"/>
      {{-- Green base fill --}}
      <rect x="0" y="56" width="1440" height="24" fill="#1a5c38"/>
      {{-- Central grand pointed arch --}}
      <path d="M580,56 C580,56 600,30 620,14 C640,0 660,0 680,0 L760,0 C780,0 800,0 820,14 C840,30 860,56 860,56 Z" fill="#1a5c38"/>
      {{-- Left secondary arch --}}
      <path d="M330,56 C330,56 345,34 358,22 C371,10 384,8 396,8 L444,8 C456,8 469,10 482,22 C495,34 510,56 510,56 Z" fill="#1a5c38"/>
      {{-- Right secondary arch --}}
      <path d="M930,56 C930,56 945,34 958,22 C971,10 984,8 996,8 L1044,8 C1056,8 1069,10 1082,22 C1095,34 1110,56 1110,56 Z" fill="#1a5c38"/>
      {{-- Far left small arch --}}
      <path d="M100,56 C100,56 110,42 118,34 C126,26 134,24 142,24 L178,24 C186,24 194,26 202,34 C210,42 220,56 220,56 Z" fill="#1a5c38"/>
      {{-- Far right small arch --}}
      <path d="M1220,56 C1220,56 1230,42 1238,34 C1246,26 1254,24 1262,24 L1298,24 C1306,24 1314,26 1322,34 C1330,42 1340,56 1340,56 Z" fill="#1a5c38"/>
      {{-- Left + right base fill patches --}}
      <rect x="0"    y="56" width="100"  height="24" fill="#1a5c38"/>
      <rect x="1340" y="56" width="100"  height="24" fill="#1a5c38"/>
      {{-- Gold outline tracing all arch peaks --}}
      <path d="M0,56 L100,56 C100,56 110,42 118,34 C126,26 134,24 142,24 L178,24 C186,24 194,26 202,34 C210,42 220,56 220,56 L330,56 C330,56 345,34 358,22 C371,10 384,8 396,8 L444,8 C456,8 469,10 482,22 C495,34 510,56 510,56 L580,56 C580,56 600,30 620,14 C640,0 660,0 680,0 L760,0 C780,0 800,0 820,14 C840,30 860,56 860,56 L930,56 C930,56 945,34 958,22 C971,10 984,8 996,8 L1044,8 C1056,8 1069,10 1082,22 C1095,34 1110,56 1110,56 L1220,56 C1220,56 1230,42 1238,34 C1246,26 1254,24 1262,24 L1298,24 C1306,24 1314,26 1322,34 C1330,42 1340,56 1340,56 L1440,56"
            fill="none" stroke="rgba(201,164,74,0.45)" stroke-width="1.1" stroke-linejoin="round"/>
      {{-- Finial dots at arch peaks --}}
      <circle cx="720"  cy="1"  r="2.8" fill="rgba(201,164,74,.85)"/>
      <circle cx="420"  cy="9"  r="2"   fill="rgba(201,164,74,.6)"/>
      <circle cx="1020" cy="9"  r="2"   fill="rgba(201,164,74,.6)"/>
      <circle cx="160"  cy="25" r="1.5" fill="rgba(201,164,74,.4)"/>
      <circle cx="1280" cy="25" r="1.5" fill="rgba(201,164,74,.4)"/>
    </svg>
  </div>

  <div class="pf-inner">

    {{-- ── Brand + CTA Row ────────────────────────────────── --}}
    <div class="pf-top">
      <div class="pf-seal" aria-hidden="true">
        <svg viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="13" cy="13" r="11.5" stroke="#c9a44a" stroke-width="1"/>
          <path d="M13 4.5L14.6 9.5L19.8 9.5L15.6 12.6L17.2 17.6L13 14.5L8.8 17.6L10.4 12.6L6.2 9.5L11.4 9.5Z"
                stroke="#c9a44a" stroke-width=".9" fill="rgba(201,164,74,.1)" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="pf-btext">
        <span class="pf-sub">Pondok Pesantren Islam</span>
        <div class="pf-name">Al-<em>Furqoniyah</em></div>
        <p class="pf-tag">Mencetak generasi Qurani yang berakhlak mulia, berwawasan luas, dan siap menghadapi tantangan zaman dengan pondasi iman yang kokoh.</p>
      </div>
      <a href="#" class="pf-btn" id="footer-cta-daftar" role="button">
        <span>Daftar Sekarang</span>
        <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M1.5 7H12.5M8.5 3L12.5 7L8.5 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>

    {{-- ── Navigation Grid ─────────────────────────────────── --}}
    <div class="pf-grid">
      <div>
        <span class="pf-col-h">Tautan Cepat</span>
        <ul class="pf-links">
          <li><a href="#" id="f-beranda">Beranda</a></li>
          <li><a href="#" id="f-profil">Profil Pesantren</a></li>
          <li><a href="#" id="f-berita">Berita &amp; Kegiatan</a></li>
          <li><a href="#" id="f-galeri">Galeri Foto</a></li>
          <li><a href="#" id="f-kontak">Hubungi Kami</a></li>
        </ul>
      </div>
      <div>
        <span class="pf-col-h">Program Unggulan</span>
        <ul class="pf-links">
          <li><a href="#" id="f-tahfidz">Tahfidz Quran</a></li>
          <li><a href="#" id="f-madin">Madrasah Diniyah</a></li>
          <li><a href="#" id="f-formal">Pendidikan Formal</a></li>
          <li><a href="#" id="f-ekskul">Ekstrakurikuler</a></li>
          <li><a href="#" id="f-psb">Penerimaan Santri Baru</a></li>
        </ul>
      </div>
      <div>
        <span class="pf-col-h">Kontak Kami</span>
        <ul class="pf-ci">
          <li>
            <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7 1C4.79 1 3 2.79 3 5C3 8 7 13 7 13S11 8 11 5C11 2.79 9.21 1 7 1Z" stroke="currentColor" stroke-width="1.1" stroke-linejoin="round"/>
              <circle cx="7" cy="5" r="1.4" stroke="currentColor" stroke-width="1.1"/>
            </svg>
            <span>Jl. Pesantren Raya No. 1<br>Kab. Jawa Tengah 57400</span>
          </li>
          <li>
            <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="1" y="3" width="12" height="8" rx=".7" stroke="currentColor" stroke-width="1.1"/>
              <path d="M1 3.5L7 8L13 3.5" stroke="currentColor" stroke-width="1.1" stroke-linecap="round"/>
            </svg>
            <span>info@alfurqoniyah.sch.id</span>
          </li>
          <li>
            <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M2 2H4.5L6 4.8L4.5 6C5.4 7.7 6.3 8.6 8 9.5L9.2 8L12 9.5V12C12 12 9.5 13 6.5 10C3.5 7 2 2 2 2Z" stroke="currentColor" stroke-width="1.1" stroke-linejoin="round"/>
            </svg>
            <span>(0271) 123-4567</span>
          </li>
        </ul>
      </div>
    </div>

    {{-- ── Bottom Bar ──────────────────────────────────────── --}}
    <div class="pf-bot">
      <div class="pf-verse">
        <span class="pf-ar" lang="ar" dir="rtl">وَعَلَّمَ آدَمَ الْأَسْمَاءَ كُلَّهَا</span>
        <span class="pf-tr">"Dan Dia mengajarkan kepada Adam nama-nama (benda) semuanya"</span>
        <span class="pf-ref">— QS. Al-Baqarah: 31</span>
      </div>
      <div class="pf-right">
        <nav class="pf-soc" aria-label="Media sosial Al-Furqoniyah">
          <a href="#" id="f-ig" aria-label="Instagram">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="2" y="2" width="16" height="16" rx="4.5" stroke="currentColor" stroke-width="1.4"/>
              <circle cx="10" cy="10" r="3.5" stroke="currentColor" stroke-width="1.4"/>
              <circle cx="14.2" cy="5.8" r="1" fill="currentColor"/>
            </svg>
          </a>
          <a href="#" id="f-yt" aria-label="YouTube">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="1.5" y="4" width="17" height="12" rx="2.5" stroke="currentColor" stroke-width="1.4"/>
              <path d="M8 7.5L13.5 10L8 12.5V7.5Z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
            </svg>
          </a>
          <a href="#" id="f-fb" aria-label="Facebook">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14 2H12C10.34 2 9 3.34 9 5V8H7V11H9V18H12V11H14L14.5 8H12V5C12 4.45 12.45 4 13 4H14V2Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
            </svg>
          </a>
          <a href="#" id="f-wa" aria-label="WhatsApp">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M10 2C5.58 2 2 5.58 2 10C2 11.5 2.42 12.9 2.1 14L1.5 18L5.6 17.3C6.8 17.8 8 18 10 18C14.42 18 18 14.42 18 10C18 5.58 14.42 2 10 2Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
              <path d="M7 8.5C7 8.5 7 12 12 13" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              <path d="M7 8.5L8 7.5H9.5L10 9L9 9.8" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
          <a href="#" id="f-tt" aria-label="TikTok">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M13 2C13.3 4.5 15 6 17 6.3V9.1C15.4 9 14 8.4 13 7.4V14C13 16.8 10.8 19 8 19C5.2 19 3 16.8 3 14C3 11.2 5.2 9 8 9C8.3 9 8.6 9 9 9.1V12C8.7 11.9 8.4 11.9 8 11.9C6.8 11.9 6 12.8 6 14C6 15.2 6.9 16 8 16C9.2 16 10 15.2 10 14V2H13Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
            </svg>
          </a>
        </nav>
        <div class="pf-copy">
          &copy; {{ date('Y') }} Pondok Pesantren Al-Furqoniyah.<br>
          Seluruh hak cipta dilindungi.&nbsp;·&nbsp;
          <a href="#" id="f-priv">Kebijakan Privasi</a>&nbsp;·&nbsp;
          <a href="#" id="f-terms">Ketentuan</a>
        </div>
      </div>
    </div>

  </div>{{-- /.pf-inner --}}
</footer>

<script>
(function(){
  var footer = document.getElementById('pf-footer');
  var nur    = document.getElementById('pf-nur');
  if(!footer || !nur) return;
  footer.addEventListener('mousemove', function(e){
    var r = footer.getBoundingClientRect();
    var x = ((e.clientX - r.left) / r.width  * 100).toFixed(1);
    var y = ((e.clientY - r.top)  / r.height * 100).toFixed(1);
    nur.style.background = 'radial-gradient(circle at '+x+'% '+y+'%, rgba(201,164,74,.09) 0%, rgba(201,164,74,.03) 28%, transparent 55%)';
  });
  footer.addEventListener('mouseleave', function(){
    nur.style.background = 'radial-gradient(circle at 50% 50%, rgba(201,164,74,.05) 0%, transparent 55%)';
  });
})();
</script>
