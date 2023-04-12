<!-- Struc Data -->
<?php if($template=='product/product_detail') { ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Product",
            "name": "<?=$pro_detail['name']?>",
            "image":
            [
                "<?=$config_url_http.UPLOAD_PRODUCT_L.$pro_detail['photo']?>"
            ],
            "description": "<?=$description_share?>",
            "sku":"SP0<?=$pro_detail['id']?>",
            "mpn": "925872",
            "brand":
            {
                "@type": "Thing",
                "name": "<?=($category['name']!='') ? $category['name'] : $optsetting['name']?>"
            },
            "review":
            {
                "@type": "Review",
                "reviewRating":
                {
                    "@type": "Rating",
                    "ratingValue": "5",
                    "bestRating": "5"
                },
                "author":
                {
                    "@type": "Person",
                    "name": "<?=$optsetting['name']?>"
                }
            },
            "aggregateRating":
            {
                "@type": "AggregateRating",
                "ratingValue": "4.4",
                "reviewCount": "89"
            },
            "offers":
            {
                "@type": "Offer",
                "url": "<?=$func->getCurrentPageURL()?>",
                "priceCurrency": "VND",
                "price": "<?=$pro_detail['price']?>",
                "priceValidUntil": "2020-11-05",
                "itemCondition": "https://schema.org/UsedCondition",
                "availability": "https://schema.org/InStock",
                "seller":
                {
                    "@type": "Organization",
                    "name": "Executive Objects"
                }
            }
        }
    </script>
<?php } else if($template=='post/post_detail') { ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "mainEntityOfPage":
            {
                "@type": "WebPage",
                "@id": "https://google.com/article"
            },
            "headline": "<?=$post_detail['name']?>",
            "image":
            [
                "<?=$config_url_http.UPLOAD_POST_L.$post_detail['photo']?>"
            ],
            "datePublished": "<?=date('Y-m-d',$post_detail['date_created'])?>",
            "dateModified": "<?=date('Y-m-d',$post_detail['date_created'])?>",
            "author":
            {
                "@type": "Person",
                "name": "<?=$optsetting['name']?>"
            },
            "publisher":
            {
                "@type": "Organization",
                "name": "Google",
                "logo":
                {
                    "@type": "ImageObject",
                    "url": "<?=$config_url_http.$func->get_photoSelect('logo', '100x100x1')?>"
                }
            },
            "description": "<?=$description_share?>"
        }
    </script>
<?php } else if($template=='static/static') { ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "mainEntityOfPage":
            {
                "@type": "WebPage",
                "@id": "https://google.com/article"
            },
            "headline": "<?=@$static_detail['name']?>",
            "image":
            [
                "<?=$config_url_http.UPLOAD_PHOTO_L.@$static_detail['photo']?>"
            ],
            "datePublished": "<?=date('Y-m-d',@$static_detail['date_created'])?>",
            "dateModified": "<?=date('Y-m-d',@$static_detail['date_created'])?>",
            "author":
            {
                "@type": "Person",
                "name": "<?=$optsetting['name']?>"
            },
            "publisher":
            {
                "@type": "Organization",
                "name": "Google",
                "logo":
                {
                    "@type": "ImageObject",
                    "url": "<?=$config_url_http.$func->get_photoSelect('logo', '100x100x1')?>"
                }
            },
            "description": "<?=@$description_share?>"
        }
    </script>
<?php } else { ?>
    <script type="application/ld+json">
        {
            "@context" : "https://schema.org",
            "@type" : "Organization",
            "name" : "<?=$optsetting['name']?>",
            "url" : "<?=$config_url_http?>",
            "sameAs" :
            [

                <?php foreach ($slider['social'] as $i => $item) {
                    if(!empty($item['link'])) echo $item['link'].',';
                } ?>
            ],
            "address":
            {
                "@type": "PostalAddress",
                "streetAddress": "<?=$optsetting['address']?>",
                "addressRegion": "Ho Chi Minh",
                "postalCode": "70000",
                "addressCountry": "vi"
            }
        }
    </script>
<?php } ?>