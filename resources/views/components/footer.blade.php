{{-- ============================================================
     Al-Furqoniyah — Premium Pesantren Footer (Main Site)
     Warm Emerald · Islamic Arch Divider · Nur Lantern Glow
     Giant Watermark · Arabic Calligraphy · Ambient Mouse Effect
     ============================================================ --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Source+Sans+3:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* ── Variables ─────────────────────────────────────────────── */
.pf{
  --g:#1a5c38;--gold:#c9a44a;--gl:#e0bc6e;--gp:#f4e5b2;
  --cr:#f6f1e8;--cd:rgba(246,241,232,.62);
  --br:rgba(201,164,74,.22);
}

/* ── Logo Pill (mirrors navbar treatment) ──────────────────── */
.pf-logo-pill{
  flex-shrink:0;
  background:#fff;
  border-radius:0 0 20px 20px;
  border-bottom:3px solid var(--gold);
  padding:.6rem .8rem 1rem;
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 8px 24px rgba(0,0,0,.25),0 2px 8px rgba(0,0,0,.15);
  position:relative;
  transition:transform .3s ease,box-shadow .3s ease;
}
.pf-logo-pill:hover{
  transform:translateY(-3px);
  box-shadow:0 12px 32px rgba(0,0,0,.3),0 4px 12px rgba(0,0,0,.2);
}
.pf-logo-pill::before{
  content:'';
  position:absolute;top:0;left:0;right:0;
  height:3px;
  background:linear-gradient(90deg,var(--gold),#e8c55a,var(--gold));
  border-radius:0;
  opacity:.7;
}
.pf-logo-pill img{
  width:56px;height:56px;
  object-fit:contain;
  display:block;
}

/* ── Base ──────────────────────────────────────────────────── */
.pf{
  background-color:var(--g);
  color:var(--cr);
  font-family:'Source Sans 3',sans-serif;
  position:relative;
  overflow:hidden;
}

/* ── Paper/Canvas Noise Texture ────────────────────────────── */
.pf::before{
  content:'';
  position:absolute;inset:0;z-index:0;pointer-events:none;
  opacity:.05;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='250' height='250'%3E%3Cfilter id='f'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.88' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='250' height='250' filter='url(%23f)'/%3E%3C/svg%3E");
  background-size:250px 250px;
}

/* ── Ambient Lantern Glow (Nur) Layer ──────────────────────── */
.pf-nur{
  position:absolute;inset:0;z-index:1;pointer-events:none;
  background:radial-gradient(circle at 50% 50%,rgba(201,164,74,.06) 0%,transparent 55%);
  transition:background .08s linear;
}

/* ── Giant Watermark Typography ────────────────────────────── */
.pf-watermark{
  position:absolute;
  top:50%;left:50%;
  transform:translate(-50%,-50%);
  font-family:'Playfair Display',serif;
  font-weight:900;
  font-size:clamp(4.5rem,12vw,11rem);
  white-space:nowrap;
  letter-spacing:.1em;
  color:rgba(246,241,232,.038);
  user-select:none;pointer-events:none;
  line-height:1;z-index:0;
  text-transform:uppercase;
}

/* ── All content above layers ──────────────────────────────── */
.pf-inner{
  position:relative;z-index:2;
  max-width:1200px;margin:0 auto;
  padding:0 2.5rem 2.5rem;
}

/* ── Pointed Islamic Arch Divider ──────────────────────────── */
.pf-arch{line-height:0;overflow:hidden;}
.pf-arch svg{display:block;width:100%;height:auto;}

/* ── Brand + CTA Row ───────────────────────────────────────── */
.pf-top{
  display:flex;align-items:center;gap:2rem;
  padding:2.5rem 0 2rem;
  border-bottom:1px solid var(--br);
  flex-wrap:wrap;
}
.pf-seal{
  flex-shrink:0;width:52px;height:52px;
  border:1.5px solid rgba(201,164,74,.5);
  border-radius:50%;display:flex;align-items:center;justify-content:center;
  background:rgba(201,164,74,.07);
}
.pf-seal svg{width:26px;height:26px;}
.pf-btext{flex:1;min-width:200px;}
.pf-sub{
  font-size:.68rem;font-weight:500;letter-spacing:.2em;
  text-transform:uppercase;color:var(--gold);display:block;margin-bottom:.3rem;
}
.pf-name{
  font-family:'Playfair Display',serif;
  font-size:clamp(1.3rem,2.5vw,1.85rem);
  font-weight:700;letter-spacing:.03em;color:var(--cr);line-height:1;
}
.pf-name em{color:var(--gold);font-style:normal;}
.pf-tag{font-size:.85rem;font-weight:300;color:var(--cd);line-height:1.65;margin-top:.35rem;max-width:420px;}

/* ── Register Button ───────────────────────────────────────── */
.pf-btn{
  flex-shrink:0;
  display:inline-flex;align-items:center;gap:.55rem;
  padding:.78rem 1.7rem;
  background:var(--gold);color:#1a3020;
  font-family:'Source Sans 3',sans-serif;
  font-size:.83rem;font-weight:600;letter-spacing:.06em;
  text-decoration:none;border-radius:8px;
  box-shadow:0 2px 16px rgba(201,164,74,.3);
  transition:background .22s,transform .2s,box-shadow .22s;
}
.pf-btn:hover{
  background:var(--gl);transform:translateY(-2px);
  box-shadow:0 6px 24px rgba(201,164,74,.44);color:#1a3020;
}
.pf-btn svg{width:14px;height:14px;transition:transform .22s;}
.pf-btn:hover svg{transform:translateX(3px);}

/* ── Navigation Grid ───────────────────────────────────────── */
.pf-grid{
  display:grid;grid-template-columns:repeat(3,1fr);
  gap:1.5rem 2.5rem;padding:2rem 0;
  border-bottom:1px solid var(--br);
}
.pf-col-h{
  font-size:.66rem;font-weight:600;letter-spacing:.22em;
  text-transform:uppercase;color:var(--gold);
  display:block;margin-bottom:1rem;
}
.pf-links{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:.62rem;}
.pf-links a{
  text-decoration:none;color:var(--cd);
  font-size:.9rem;font-weight:300;line-height:1.5;
  display:inline-block;position:relative;padding-left:0;
  transition:color .2s,padding-left .2s;
}
.pf-links a::before{
  content:'—';position:absolute;left:-1.1rem;
  opacity:0;color:var(--gold);font-size:.7rem;
  transition:opacity .2s,left .2s;
}
.pf-links a:hover{color:var(--cr);padding-left:1rem;}
.pf-links a:hover::before{opacity:1;left:0;}
.pf-ci{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:.88rem;}
.pf-ci li{display:flex;align-items:flex-start;gap:.6rem;font-size:.86rem;font-weight:300;color:var(--cd);line-height:1.55;}
.pf-ci svg{width:14px;height:14px;color:var(--gold);flex-shrink:0;margin-top:2px;}

/* ── Bottom Bar ────────────────────────────────────────────── */
.pf-bot{
  display:flex;align-items:flex-start;
  justify-content:space-between;
  gap:2rem;padding-top:1.8rem;flex-wrap:wrap;
}
/* Arabic verse */
.pf-verse{display:flex;flex-direction:column;gap:.4rem;}
.pf-ar{
  font-family:'Traditional Arabic','Scheherazade New','Amiri','Noto Naskh Arabic',serif;
  font-size:1.6rem;direction:rtl;color:var(--gp);
  line-height:1.9;letter-spacing:.02em;display:block;
}
.pf-tr{
  font-family:'Playfair Display',serif;font-style:italic;
  font-size:.8rem;color:rgba(246,241,232,.58);letter-spacing:.02em;
}
.pf-ref{
  font-size:.68rem;color:rgba(201,164,74,.62);
  letter-spacing:.1em;text-transform:uppercase;margin-top:.1rem;
}
/* Right: socials + copyright */
.pf-right{display:flex;flex-direction:column;align-items:flex-end;gap:1.1rem;}
/* Free-floating social icons — NO boxes */
.pf-soc{display:flex;align-items:center;gap:1.35rem;}
.pf-soc a{
  display:flex;color:rgba(246,241,232,.38);
  text-decoration:none;transition:color .22s,transform .22s;
}
.pf-soc a svg{width:19px;height:19px;}
.pf-soc a:hover{color:var(--gold);transform:translateY(-3px);}
.pf-copy{
  font-size:.71rem;font-weight:400;
  color:rgba(246,241,232,.47);letter-spacing:.05em;
  text-align:right;line-height:1.75;
}
.pf-copy a{color:rgba(246,241,232,.52);text-decoration:none;transition:color .2s;}
.pf-copy a:hover{color:var(--gold);}

/* ── Responsive ─────────────────────────────────────────────── */
@media(max-width:900px){
  .pf-inner{padding:0 1.5rem 2rem;}
  .pf-grid{grid-template-columns:1fr 1fr;}
  .pf-btn{width:100%;}
}
@media(max-width:580px){
  .pf-inner{padding:0 1.25rem 2rem;}
  .pf-grid{grid-template-columns:1fr;gap:1.5rem;}
  .pf-bot{flex-direction:column;}
  .pf-right{align-items:flex-start;}
  .pf-copy{text-align:left;}
  .pf-watermark{font-size:3.5rem;letter-spacing:.06em;}
}
</style>

<footer class="pf" role="contentinfo" aria-label="Footer Al-Furqoniyah" id="pf-footer">

  {{-- Ambient Lantern Glow --}}
  <div class="pf-nur" id="pf-nur" aria-hidden="true"></div>

  {{-- Giant Background Watermark --}}
  <div class="pf-watermark" aria-hidden="true">AL-FURQONIYAH</div>

  {{-- ── Pointed Islamic Arch Divider ─────────────────────── --}}
  <div class="pf-arch" aria-hidden="true">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      {{-- Background color of section above (white/light) --}}
      <rect width="1440" height="80" fill="#f8fafc"/>
      {{-- Flat green base --}}
      <rect x="0" y="56" width="1440" height="24" fill="#1a5c38"/>
      {{-- Central grand pointed arch --}}
      <path d="M580,56 C580,56 608,28 628,12 C648,0 668,0 688,0 L752,0 C772,0 792,0 812,12 C832,28 860,56 860,56 Z" fill="#1a5c38"/>
      {{-- Left secondary arch --}}
      <path d="M328,56 C328,56 344,32 358,20 C372,8 386,7 398,7 L444,7 C456,7 470,8 484,20 C498,32 512,56 512,56 Z" fill="#1a5c38"/>
      {{-- Right secondary arch --}}
      <path d="M928,56 C928,56 944,32 958,20 C972,8 986,7 998,7 L1044,7 C1056,7 1070,8 1084,20 C1098,32 1112,56 1112,56 Z" fill="#1a5c38"/>
      {{-- Far-left small arch --}}
      <path d="M98,56 C98,56 110,40 120,32 C130,24 138,23 148,23 L180,23 C190,23 198,24 208,32 C218,40 222,56 222,56 Z" fill="#1a5c38"/>
      {{-- Far-right small arch --}}
      <path d="M1218,56 C1218,56 1230,40 1240,32 C1250,24 1258,23 1268,23 L1298,23 C1308,23 1316,24 1326,32 C1336,40 1342,56 1342,56 Z" fill="#1a5c38"/>
      {{-- Edge fills --}}
      <rect x="0"    y="56" width="98"   height="24" fill="#1a5c38"/>
      <rect x="1342" y="56" width="98"   height="24" fill="#1a5c38"/>
      {{-- Gold outline tracing all arch peaks --}}
      <path d="M0,56
               L98,56 C98,56 110,40 120,32 C130,24 138,23 148,23 L180,23 C190,23 198,24 208,32 C218,40 222,56 222,56
               L328,56 C328,56 344,32 358,20 C372,8 386,7 398,7 L444,7 C456,7 470,8 484,20 C498,32 512,56 512,56
               L580,56 C580,56 608,28 628,12 C648,0 668,0 688,0 L752,0 C772,0 792,0 812,12 C832,28 860,56 860,56
               L928,56 C928,56 944,32 958,20 C972,8 986,7 998,7 L1044,7 C1056,7 1070,8 1084,20 C1098,32 1112,56 1112,56
               L1218,56 C1218,56 1230,40 1240,32 C1250,24 1258,23 1268,23 L1298,23 C1308,23 1316,24 1326,32 C1336,40 1342,56 1342,56
               L1440,56"
            fill="none" stroke="rgba(201,164,74,0.48)" stroke-width="1.2" stroke-linejoin="round"/>
      {{-- Finial accent dots at arch peaks --}}
      <circle cx="720"  cy="1"  r="2.8" fill="rgba(201,164,74,.85)"/>
      <circle cx="421"  cy="8"  r="2"   fill="rgba(201,164,74,.6)"/>
      <circle cx="1021" cy="8"  r="2"   fill="rgba(201,164,74,.6)"/>
      <circle cx="164"  cy="24" r="1.5" fill="rgba(201,164,74,.42)"/>
      <circle cx="1283" cy="24" r="1.5" fill="rgba(201,164,74,.42)"/>
    </svg>
  </div>

  <div class="pf-inner">

    {{-- ── Brand + CTA Row ────────────────────────────────── --}}
    <div class="pf-top">
      <div class="pf-logo-pill">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Al-Furqoniyah">
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

    {{-- ── Navigation Grid (layered over watermark) ────────── --}}
    <div class="pf-grid">
      <div>
        <span class="pf-col-h">Tautan Cepat</span>
        <ul class="pf-links">
          <li><a href="/" id="f-beranda">Beranda</a></li>
          <li><a href="#" id="f-profil">Profil Pesantren</a></li>
          <li><a href="#" id="f-berita">Berita &amp; Kegiatan</a></li>
          <li><a href="#" id="f-galeri">Galeri Foto</a></li>
          <li><a href="{{ route('contact') }}" id="f-kontak">Hubungi Kami</a></li>
        </ul>
      </div>
      <div>
        <span class="pf-col-h">Program Unggulan</span>
        <ul class="pf-links">
          <li><a href="#" id="f-tahfidz">Tahfidz Al-Quran</a></li>
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
            <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M7 1C4.79 1 3 2.79 3 5C3 8 7 13 7 13S11 8 11 5C11 2.79 9.21 1 7 1Z" stroke="currentColor" stroke-width="1.1" stroke-linejoin="round"/>
              <circle cx="7" cy="5" r="1.4" stroke="currentColor" stroke-width="1.1"/>
            </svg>
            <span>Jl. Pesantren Raya, Cigombong<br>Kab. Bogor, Jawa Barat</span>
          </li>
          <li>
            <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect x="1" y="3" width="12" height="8" rx=".7" stroke="currentColor" stroke-width="1.1"/>
              <path d="M1 3.5L7 8L13 3.5" stroke="currentColor" stroke-width="1.1" stroke-linecap="round"/>
            </svg>
            <span>info@alfurqoniyah.sch.id</span>
          </li>
          <li>
            <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M2 2H4.5L6 4.8L4.5 6C5.4 7.7 6.3 8.6 8 9.5L9.2 8L12 9.5V12C12 12 9.5 13 6.5 10C3.5 7 2 2 2 2Z" stroke="currentColor" stroke-width="1.1" stroke-linejoin="round"/>
            </svg>
            <span>(0251) 123-4567</span>
          </li>
        </ul>
      </div>
    </div>

    {{-- ── Bottom: Arabic Verse + Socials + Copyright ──────── --}}
    <div class="pf-bot">
      <div class="pf-verse">
        <span class="pf-ar" lang="ar" dir="rtl">وَعَلَّمَ آدَمَ الْأَسْمَاءَ كُلَّهَا</span>
        <span class="pf-tr">"Dan Dia mengajarkan kepada Adam nama-nama (benda) semuanya"</span>
        <span class="pf-ref">— QS. Al-Baqarah: 31</span>
      </div>
      <div class="pf-right">
        <nav class="pf-soc" aria-label="Media sosial Al-Furqoniyah">
          <a href="https://www.youtube.com/@pesantrenalfurqoniyah47" target="_blank" rel="noopener noreferrer" class="pf-soc" id="f-yt" aria-label="YouTube Al-Furqoniyah">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="1.5" y="4" width="17" height="12" rx="2.5" stroke="currentColor" stroke-width="1.4"/>
              <path d="M8 7.5L13.5 10L8 12.5V7.5Z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
            </svg>
          </a>
          <a href="#" id="f-ig" aria-label="Instagram Al-Furqoniyah">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="2" y="2" width="16" height="16" rx="4.5" stroke="currentColor" stroke-width="1.4"/>
              <circle cx="10" cy="10" r="3.5" stroke="currentColor" stroke-width="1.4"/>
              <circle cx="14.2" cy="5.8" r="1" fill="currentColor"/>
            </svg>
          </a>
          <a href="#" id="f-fb" aria-label="Facebook Al-Furqoniyah">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14 2H12C10.34 2 9 3.34 9 5V8H7V11H9V18H12V11H14L14.5 8H12V5C12 4.45 12.45 4 13 4H14V2Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
            </svg>
          </a>
          <a href="#" id="f-wa" aria-label="WhatsApp Al-Furqoniyah">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M10 2C5.58 2 2 5.58 2 10C2 11.5 2.42 12.9 2.1 14L1.5 18L5.6 17.3C6.8 17.8 8 18 10 18C14.42 18 18 14.42 18 10C18 5.58 14.42 2 10 2Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
              <path d="M7 8.5C7 8.5 7 12 12 13" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              <path d="M7 8.5L8 7.5H9.5L10 9L9 9.8" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
          <a href="#" id="f-tt" aria-label="TikTok Al-Furqoniyah">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M13 2C13.3 4.5 15 6 17 6.3V9.1C15.4 9 14 8.4 13 7.4V14C13 16.8 10.8 19 8 19C5.2 19 3 16.8 3 14C3 11.2 5.2 9 8 9C8.3 9 8.6 9 9 9.1V12C8.7 11.9 8.4 11.9 8 11.9C6.8 11.9 6 12.8 6 14C6 15.2 6.9 16 8 16C9.2 16 10 15.2 10 14V2H13Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
            </svg>
          </a>
        </nav>
        <div class="pf-copy">
          &copy; {{ date('Y') }} Pondok Pesantren Al-Furqoniyah.<br>
          Seluruh hak cipta dilindungi.&nbsp;·&nbsp;
          <a href="#" id="f-priv">Kebijakan Privasi</a>&nbsp;·&nbsp;
          <a href="#" id="f-terms">Ketentuan Layanan</a>
        </div>
      </div>
    </div>

  </div>{{-- /.pf-inner --}}
</footer>

<script>
(function(){
  var f=document.getElementById('pf-footer');
  var n=document.getElementById('pf-nur');
  if(!f||!n)return;
  f.addEventListener('mousemove',function(e){
    var r=f.getBoundingClientRect();
    var x=((e.clientX-r.left)/r.width*100).toFixed(1);
    var y=((e.clientY-r.top)/r.height*100).toFixed(1);
    n.style.background='radial-gradient(circle at '+x+'% '+y+'%,rgba(201,164,74,.09) 0%,rgba(201,164,74,.03) 30%,transparent 58%)';
  });
  f.addEventListener('mouseleave',function(){
    n.style.background='radial-gradient(circle at 50% 50%,rgba(201,164,74,.05) 0%,transparent 55%)';
  });
})();
</script>
