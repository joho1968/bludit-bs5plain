<?php
defined( 'BLUDIT' ) || die( 'That did not work as expected.' );
/*
 * bs5plain theme for Bludit
 *
 * index.php (bs5plain)
 * Copyright 2024 Joaquim Homrighausen; all rights reserved.
 * Development sponsored by WebbPlatsen i Sverige AB, www.webbplatsen.se
 *
 * This file is part of bs5plain. bs5plain is free software.
 *
 * bs5plain is free software: you may redistribute it and/or modify it  under
 * the terms of the GNU AFFERO GENERAL PUBLIC LICENSE v3 as published by the
 * Free Software Foundation.
 *
 * bs5plain is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU AFFERO GENERAL PUBLIC LICENSE
 * v3 for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE v3
 * along with the bs5plain package. If not, write to:
 *  The Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor
 *  Boston, MA  02110-1301, USA.
 */
?>
<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    echo Theme::metaTagTitle();
    echo Theme::metaTagDescription();
    echo Theme::favicon( 'res/img/favicon.png' );
    echo '<link rel="stylesheet" type="text/css" href="' . DOMAIN_THEME . 'res/css/bootstrap.min.css">' . "\n";
    echo '<link rel="stylesheet" type="text/css" href="' . DOMAIN_THEME . 'css/bs5plain.css">' . "\n";
    Theme::plugins( 'siteHead' );
    ?>
</head>
<body class="d-flex flex-column h-100 bg-body-tertiary">
    <script>
        (() => {
            'use strict';
            const colorMode = window.matchMedia("(prefers-color-scheme: dark)").matches ?
                "dark" :
                "light";
            document.querySelector("html").setAttribute("data-bs-theme", colorMode);
        })();

        (() => {
            'use strict';

            // Set theme to the user's preferred color scheme
            function updateBootstrapTheme() {
                const colorMode = window.matchMedia("(prefers-color-scheme: dark)").matches ?
                    "dark" :
                    "light";
                document.querySelector("html").setAttribute("data-bs-theme", colorMode);
            }
            function documentSetup() {
                // Update theme when the preferred scheme changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateBootstrapTheme);
                // Some more BS initialization
                const popoverTriggerList = document.querySelectorAll('[data-bs-toggle=\"popover\"]');
                const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
            }
            if (document.readyState === 'complete' ||
                    (document.readyState !== 'loading' && !document.documentElement.doScroll)) {
                documentSetup();
            } else {
                document.addEventListener('DOMContentLoaded', documentSetup);
            }
        })();
    </script>

    <?php Theme::plugins( 'siteBodyBegin' ); ?>
    <nav class="navbar bg-body-secondary fixed-top mb-5">
        <div class="container d-flex flex-row justify-content-between">
            <div>
                <button class="btn btn-outline-secondary btn-sm me-2 mb-1 mb-md-2"
                        type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasmenu" aria-controls="offcanvasmenu"
                        title="<?php echo $L->get( 'menu' ); ?>"
                        aria-label="<?php echo $L->get( 'menu' ); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand bold p-0 m-0 fs-4" href="<?php echo $site->url() ?>">
                    <?php
                    if ( $site->logo() && ! $site->description() && ! $site->slogan() ) {
                        echo '<img class="img-thumbnail rounded-circle bs5plain-logo-img-header d-inline-block align-top me-2" src="' . $site->logo() . '" alt="" />';
                    }
                    echo $site->title();
                    ?>
                </a>
            </div>
            <div class="d-flex flex-row flex-nowrap  mb-1 mb-md-2 pt-2 justify-content-end">
                <?php
                $pageNotFound = $site->pageNotFound();
                foreach( $staticContent as $item ) {
                    if ( ! $item->isChild() && ! empty( $item->title() ) && $item->key() != $pageNotFound ) {
                        echo '<div class="text-nowrap text-overflow">';
                        echo '<a class="btn btn-outline-secondary btn-sm text-decoration-none ms-1 ms-md-3 mb-2 mb-md-1" href="' . $item->permalink() . '" role="button">' .
                             $item->title() . '</a>' .
                             "\n";
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start h-auto bs5plain-notransition bg-body" tabindex="-1" id="offcanvasmenu" aria-labelledby="offcanvasmenuLabel" data-bs-scroll="true" data-bs-keyboard="true" data-bs-backdrop="true" style="--bs-bg-opacity: .9; min-width:250px !important;">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title d-none" id="offcanvasmenuLabel">
            <?php echo $L->get( 'offcanvas-menu' ); ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="<?php echo $L->get( 'close' ); ?>">
        </button>
      </div>
      <div class="offcanvas-body py-2" role="navigation">
        <div class="bs5offcanvas-section">
            <?php Theme::plugins('siteSidebar') ?>
        </div>
        <?php
        if ( ! empty( Theme::socialNetworks() ) ) {
        ?>
        <div class="bs5offcanvas-section">
            <div class="h5">
                <?php echo $L->get( 'social-media' ); ?>
            </div>
            <div>
                <?php
                foreach( Theme::socialNetworks() as $key => $label ) {
                ?>
                <div class="d-inline-flex flex-row ms-2">
                    <div class="p-1">
                        <a class="text-decoration-none" href="<?php echo $site->{$key}(); ?>" target="_blank">
                            <img class="img-thumbnail bg-light bs5socialmedia-icon" loading="lazy" src="<?php echo DOMAIN_THEME . 'res/img/' . $key . '.png' ?>" alt="<?php echo $label ?>" title="<?php echo $site->{$key}(); ?>" />
                        </a>
                    </div>
                </div>
                <?php
                }
                ?>
                </ul>
            </div>
        </div>
        <?php
        }
        ?>
        <?php
        // RSS
        if ( Theme::rssUrl() ) {
            echo '<div class="bs5offcanvas-section"><div class="h5">RSS</div>';
            echo '<a class="text-decoration-none ms-2" href="' .
                 Theme::rssUrl() . '" target="_blank" role="button" title="' . Theme::rssUrl() . '">' .
                 '<img class="img-thumbnail bs5socialmedia-icon" loading="lazy" src="' . DOMAIN_THEME . 'res/img/rss.png' . '" alt="RSS" />' .
                 '</a>';
            echo '</div>';
        }
        ?>
      </div>
    </div>


    <main class="flex-shrink-0">
        <div class="container">
            <?php
            if ( $WHERE_AM_I == 'page' ) {
                require_once( THEME_DIR_PHP . 'page.php' );
            } else {
                require_once( THEME_DIR_PHP . 'home.php' );
            }
            ?>
        </div>
    </main>

    <?php
    @ include( THEME_DIR_PHP . 'footer.php' );
    echo '<script src="' . DOMAIN_THEME . 'res/js/bootstrap.bundle.min.js" defer></script>';
    Theme::plugins( 'siteBodyEnd' );
    ?>
</body>
</html>
