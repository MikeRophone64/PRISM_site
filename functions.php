<?php
/**
 * PRISM Theme — functions.php
 * Minimal WordPress setup. All styling is self-contained in each page template.
 */

// ── Theme support ──────────────────────────────────────────────────────────
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption']);
});

// ── Remove WordPress default styles that interfere ────────────────────────
add_action('wp_enqueue_scripts', function () {
    // Dequeue default block styles — not needed for this theme
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
}, 100);

// ── Clean up wp_head() output ─────────────────────────────────────────────
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

// ── Schema ─────────────────────────────────────────────
function prism_schema_markup() {
    $schema = [
        "@context" => "https://schema.org",
        "@graph" => [
            [
                "@type"       => "Organization",
                "@id"         => "https://prism.film/#organization",
                "name"        => "PRISM Filmmaking",
                "url"         => "https://prism.film",
                "logo"        => [
                    "@type" => "ImageObject",
                    "url"   => "https://prism.film/wp-content/uploads/2026/05/LOGO-Round_Shadows.png"
                ],
                "description" => "Nous transformons l'excellence technique invisible des entreprises tech françaises en avantage compétitif mondial.",
                "email"       => "contact@prism.film",
                "sameAs"      => [
                    "https://www.linkedin.com/company/prism-filmmaking/",
                    "https://www.instagram.com/prism.filmmaking/"
                ]
            ],
            [
                "@type"            => "Service",
                "@id"              => "https://prism.film/#tier-01",
                "name"             => "Le Signal",
                "provider"         => [ "@id" => "https://prism.film/#organization" ],
                "description"      => "Un film de conversion de 60 à 120 secondes, cadré sur un objectif unique : recrutement, vente ou pitch. Livré en formats horizontal et vertical.",
                "offers"           => [
                    "@type"         => "Offer",
                    "priceCurrency" => "EUR",
                    "price"         => "3500",
                    "priceSpecification" => [
                        "@type"         => "PriceSpecification",
                        "minPrice"      => "3500",
                        "maxPrice"      => "5000",
                        "priceCurrency" => "EUR"
                    ]
                ]
            ],
            [
                "@type"            => "Service",
                "@id"              => "https://prism.film/#tier-02",
                "name"             => "Le PRISM Essentiel",
                "provider"         => [ "@id" => "https://prism.film/#organization" ],
                "description"      => "Un écosystème narratif complet. Diagnostic, stratégie, tournage, Film Anthem 2 à 4 minutes, 3 assets LinkedIn, 10+ photos HD, Plan Narratif annuel.",
                "offers"           => [
                    "@type"         => "Offer",
                    "priceCurrency" => "EUR",
                    "price"         => "8000",
                    "priceSpecification" => [
                        "@type"         => "PriceSpecification",
                        "minPrice"      => "8000",
                        "maxPrice"      => "12000",
                        "priceCurrency" => "EUR"
                    ]
                ]
            ],
            [
                "@type"            => "Service",
                "@id"              => "https://prism.film/#tier-03",
                "name"             => "Le PRISM Protocol",
                "provider"         => [ "@id" => "https://prism.film/#organization" ],
                "description"      => "Transformation complète clé en main sur 90 jours. Diagnostic approfondi, architecture stratégique, production premium, Film Anthem 3 à 5 minutes, 5 assets LinkedIn, 20+ photos, Roadmap de déploiement, suivi à 45 jours.",
                "offers"           => [
                    "@type"         => "Offer",
                    "priceCurrency" => "EUR",
                    "price"         => "15000",
                    "priceSpecification" => [
                        "@type"         => "PriceSpecification",
                        "minPrice"      => "15000",
                        "maxPrice"      => "20000",
                        "priceCurrency" => "EUR"
                    ]
                ]
            ]
        ]
    ];
 
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}
add_action( 'wp_head', 'prism_schema_markup' );