<?php
defined( 'BLUDIT' ) || die( 'That did not work as expected.' );
/*
 * bs5plain theme for Bludit
 *
 * home.php (bs5plain)
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
    <?php

    $site_logo = $site->logo();
    $site_desc = $site->description();
    $site_slogan = $site->slogan();
    if ( $WHERE_AM_I !== 'search' && $WHERE_AM_I !== 'category' && $WHERE_AM_I !== 'tag' && ( $site_logo || $site_desc || $site_slogan ) ) {
        echo '<header>';
        echo '<div class="row my-5">';
        echo '<div class="col-12 col-lg-9 mx-auto mt-5 mt-md-4 mt-lg-0 mb-4 px-5">';
        if ( ! empty( $site_logo ) && empty( $site_desc ) && empty( $site_slogan ) ) {
            echo '<div class="mx-auto">';
            echo '<img class="img-thumbnail rounded-circle mx-auto d-block bs5plain-logo-img" src="' . $site_logo . '" alt="" />';
            echo '</div>';
        } elseif ( ! empty( $site_desc ) && empty ( $site_logo ) && empty( $site_slogan ) ) {
            echo '<h2 class="h1 ms-5 me-4 text-center mt-0 p-0">';
            echo $site_desc;
            echo '</h2>';
        } elseif ( ! empty( $site_slogan ) && empty( $site_logo ) && empty( $site_desc ) ) {
            echo '<h2 class="h1 ms-5 me-4 text-center mt-0 p-0">';
            echo $site_slogan;
            echo '</h2>';
        } elseif ( ! empty( $site_slogan ) && empty( $site_logo ) && ! empty( $site_desc ) ) {
            echo '<h2 class="ms-5 me-4 text-center mt-0 p-0">';
            echo $site_desc;
            echo '</h2>';
            echo '<h4 class="ms-5 me-4 text-center mt-0 p-0 text-body">';
            echo $site_slogan;
            echo '</h2>';
        } else {
            echo '<div class="d-flex flex-row justify-content-center">';
            if ( ! empty( $site_logo ) ) {
                echo '<div class="align-self-center">';
                echo '<img class="img-thumbnail rounded-circle bs5plain-logo-img" src="' . $site_logo . '" alt="" />';
                echo '</div>';
            }
            echo '<div class="align-self-center ms-2">';
            if ( ! empty( $site_desc ) ) {
                echo '<div class="h4 text-center mt-0 p-0">' . $site_desc . '</div>';
            }
            if ( ! empty( $site_slogan ) ) {
                if ( empty( $site_desc ) ) {
                    echo '<div class="h3 ms-0 ms-lg-4 mt-2 text-center mt-0 p-0">' . $site_slogan . '</div>';
                } else {
                    echo '<div class="ms-0 ms-lg-4 mt-2 text-center mt-0 p-0">' . $site_slogan . '</div>';
                }
            }
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';// col
        echo '</div>';// row
        echo '</header>';
    } elseif ( ! empty( $WHERE_AM_I ) ) {
        switch( $WHERE_AM_I ) {
            case 'category':
                echo '<header><div class="row"><div class="col text-center">';
                echo '<div class="d-inline-block my-5 border border-secondary rounded-2 p-3 small">';
                echo $L->get( 'browsing-content-by-category' );
                $categoryKey = $url->slug();
                $category = new Category( $categoryKey );
                echo '<span class="ms-2 badge text-bg-primary py-1 px-2">' . $category->name() . '</span></div>';
                echo '</div></div></header>';
                break;
            case 'tag':
                echo '<header><div class="row"><div class="col-12 text-center">';
                echo '<div class="d-inline-block my-5 border border-subtle rounded-2 p-3 small">';
                echo $L->get( 'browsing-content-by-tag' );
                $tagKey = $url->slug();
                $tag = new Tag( $tagKey );
                echo '<span class="ms-1 badge text-bg-primary py-1 px-2">' . $tag->name() . '</span></div>';
                echo '</div></div></header>';
                break;
            default:
                break;
        }// switch
    } else {
        echo '<header>' . '<div class="row my-5"><div class="col"></div></div></header>';
    }
    ?>


<!-- Print all the content -->
<section class="mt-5 mt-lg-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <?php
                // Make sure there's content
                if ( empty( $content ) ) {
                    echo '<div class="text-center p-4"><h3>' . $L->get( 'no-pages-found' ) . '</h3></div>';
                }
                ?>
                <?php
                $pageNotFound = $site->pageNotFound();
                // Show pages
                echo '<div>';
                foreach( $content as $post ) {
                    if ( $post->isChild() ) {
                        if ( ! empty( $WHERE_AM_I ) && $WHERE_AM_I == 'home' ) {
                            // Skip sub pages on home
                            continue;
                        }
                    } elseif ( $post->key() == $pageNotFound ) {
                        // Skip our "Page not found page" in this context
                        continue;
                    }
                    Theme::plugins('pageBegin');
                    // item start
                    // echo '<div class="mb-5 border border-secondary p-3 rounded-2">';
                    echo '<div class="shadow mb-5 bg-body p-3 rounded-2">';
                    echo '<div class="h5 text-truncate">' .
                         '<a class="link-opacity-50-hover text-decoration-none" href="' . $post->permalink() . '" title="' . $post->title() . '">' .
                         '&raquo;&nbsp;' . $post->title() . '</a>' .
                         '</div>';
                    // Content
                    echo '<div class="border-bottom mt-3 mb-3">';
                    if ( ! empty( $WHERE_AM_I ) ) {
                        switch( $WHERE_AM_I ) {
                            case 'page':
                            case 'home':
                                // Only show "full post" on 'page' and 'home'
                                echo $post->contentBreak();
                                if ( $post->readMore() ) {
                                    echo '<a class="btn btn-outline-success btn-sm text-decoration-none ms-0" href="' . $post->permalink() . '" role="button">' . $L->get( 'read-more' ) . '</a>';
                                }
                                break;
                            case 'search':
                                break;
                            case 'tag':
                                break;
                            case 'category':
                                break;
                        }
                    }// ! empty( $WHERE_AM_I )
                    echo '</div>';
                    // Post time
                    $post_time = date_create_immutable( $post->dateRaw() );
                    if ( $post_time !== false ) {
                        echo '<div class="mb-2 small text-secondary" title="' . $post_time->format( 'Y-m-d, H:i' ) . '">';
                        echo '<span class="me-2">' . '&#x1F4C5;' . '</span>' .
                             '<span class="font-monospace">' . Date::translate( $post_time->format( $site->db['dateFormat'] ) ) . '</span>';
                        echo '</div>';
                    }
                    // Check tags
                    $post_tags = $post->tags( true );
                    if ( ! empty( $post_tags ) ) {
                        echo '<div class="small">';
                        foreach( $post_tags as $tag_key => $tag_name ) {
                            echo '<a class="badge bg-secondary-subtle text-body text-decoration-none me-2 p-2" href="' .
                                 DOMAIN_TAGS . $tag_key . '">' .
                                 $tag_name .
                                 '</a>';
                        }
                        echo '</div>';
                    }
                    // item end
                    echo '</div>';
                    Theme::plugins('pageEnd');
                }// foreach

                echo '</div>';

                //Pagination
                if ( Paginator::numberOfPages() > 1 ) {
                    echo '<nav aria-label="Page navigation">';
                    echo '<ul class="pagination">';
                    if ( Paginator::showPrev() ) {
                        echo '<li class="page-item mr-2">' .
                             '<a class="page-link" href="' . Paginator::previousPageUrl() . '" tabindex="-1" aria-label="' . $L->get( 'previous' ) . '" . >' .
                             '<span aria-hidden="true">&laquo;</span>' .
                             '</a>'.
                             '</li>';
                    }
                    echo '<li class="page-item mr-2' . ( Paginator::currentPage() == 1 ? ' disabled':'' ) . '">' .
                         '<a class="page-link" href="' . Theme::siteUrl() . '" aria-label="' . $L->get( 'home' ) . '"><span aria-hidden="true">&#x1F3E0;</span></a>' .
                         '</li>';
                    if ( Paginator::showNext() ) {
                        echo '<li class="page-item mr-2">' .
                             '<a class="page-link" href="' . Paginator::nextPageUrl() . '" tabindex="-1" aria-label="' . $L->get( 'next' ) . '">' .
                             '<span aria-hidden="true">&raquo;</span>' .
                             '</a>' .
                             '</li>';
                    }
                    echo '</ul></nav>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
