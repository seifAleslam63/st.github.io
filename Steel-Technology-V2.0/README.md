# Steel Technology Website V2.0

A bilingual, dependency-free website package developed from the supplied V1.0 structured content and photographs. Original source files were not overwritten. The English site is in the root and the Arabic equivalent is in `ar/`.

## Preview on your computer

1. Extract the ZIP into its own folder.
2. Open `index.html` in Chrome or Edge. The pages, images, search, and galleries do not require external libraries. For a local HTTP preview, run `python -m http.server 8080` from the extracted folder and open `http://localhost:8080/`.
3. Use the Arabic / EN navigation to switch languages. Test equipment search, project filters, galleries, and quotation prefilling.

## Deploy to your domain

The package assumes `https://steeltechnology-eg.com/`, the domain present in the supplied V1.0 source. Confirm ownership and the desired canonical hostname before deployment. Upload the *contents* of this folder to the hosting document root (often `public_html`), not the enclosing folder. Preserve `ar`, `assets`, `css`, `js`, and `api` paths. Set up DNS and HTTPS through your domain and hosting providers. If the hostname changes, update canonical, hreflang, social, structured-data, robots and sitemap URLs. Submit sitemap.xml after launch.

The default quotation workflow prepares an email or WhatsApp draft; the customer must actually send it in that application. No data is silently submitted. Confidential drawings are intentionally not accepted by this version. Confirm contact numbers and mailbox delivery with the company before publishing.

## Optional direct quotation endpoint (PHP 8.1+)

The package contains `api/rfq.php`, which validates JSON requests, issues a unique reference and stores each inquiry in a private JSON file. It includes a basic local rate limit and honeypot. It is disabled in the frontend by default. It does not send email notifications, provide a CRM/admin UI or accept attachments.

Before enabling: configure a private writable directory **outside the website document root** via environment variable `ST_RFQ_PRIVATE_DIR` in the PHP hosting environment. Restrict access to authorized staff and configure HTTPS, host-level abuse protection, retention/deletion, backups, and a monitored staff intake workflow. Never store customer data inside the publicly served folder. Test successful and invalid submissions, private storage, and retrieval on staging. Only then set `onlineRFQ: true` in `js/config.js`. If your host cannot run PHP, leave it disabled. Delete the `api` folder on static-only hosting if desired. No secrets are included in the package.

## Content / approval notes

- Original official logo preserved at `assets/heritage-logo.png`; header mark is a crop of the existing gear/ST emblem, not a newly drawn trademark. New headline and hybrid visual treatment are proposed editorial refinements.
- All 31 referenced project photographs are optimized WebP derivatives of the supplied archive. Equipment family photographs are illustrative archive references, not product-model-specific images.
- 30 catalog entries, 6 portfolio groups, 13 listed industrial references, 2 business divisions and 8 manufacturing capabilities are retained. Client names and technical claims are company-supplied and require final internal approval; no external verification was performed.
- Removed the questionable acetylsalicylic-acid reference and softened absolute welding, scanning and certification claims. Confirm terminology, material options, hazardous-material applications and any standards or certification statements with engineering staff.
- Separate English/Arabic pages exist for home, about, fabrication, engineering, equipment, industries, projects, innovation, contact and privacy. Individual equipment URLs, formal case studies, downloadable data sheets, CRM, and email automation remain future work.
- No third-party CSS, JS, fonts or analytics requests are required. System fonts replace V1.0's remotely loaded typography.

## QA performed

Static check of 854 local asset/link/anchor references before the final navigation addition: zero missing. JavaScript and PHP syntax checks passed. Local PHP HTTP endpoint accepted a synthetic valid request and returned a reference. Chromium direct navigation was blocked by the environment, so selected pages were rendered via equivalent inline copies of the actual HTML, CSS, scripts and images: desktop home, equipment, projects, mobile English/Arabic home. Catalog search, project filter, modal next/escape and mobile navigation were exercised successfully. Screenshots are supplied separately. No live domain, real customer submission, hosted mail delivery, cross-browser or Lighthouse certification has been verified.
