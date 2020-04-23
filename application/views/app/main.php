<!-- 
    ############################################
    ##### desenvolvido por wiliamvj.com.br ##### 
    ############################################
-->

<div class="hide-for-small-only">
   <div class="row">
      <div class="medium-12 columns">
         <div class="main-statefilter">
            <div class="row">
               <div class="medium-6 columns" id="esconde">
                  <div class="ms-image">
                     <img src="assets/img/tirinha.png">
                  </div>
                  <div class="ms-text">
                     <?php
                     $slogan_pri = $this->main_model->config('cfg_slogan_pri');
                     $slogan_sec = $this->main_model->config('cfg_slogan_sec');
                     echo '
                            <h1>' . $slogan_pri . '</h1>
                            <span class="sloganSecundary">' . $slogan_sec . '</span>
                        ';
                     ?>
                  </div>
                  <br>

               </div>
               <div class="medium-6 columns">
                  <div class="ms-map" id="ms-map"></div>
               </div>
            </div>
            <div class="hide-for-small-only row">
               <div class="medium-14 columns">
                  <?php
                  $ads_count = $this->main_model->config('cfg_ads_count');

                  if ($ads_count == 1) {
                     echo '
                        <div class="ms-infos">
                           <span><i class="fa fa-tags" aria-hidden="true"></i> Total de Anúncios: <strong>' . $count_ads . '</strong> | <i class="fa fa-shopping-cart" aria-hidden="true"></i> Total de Lojas: <strong>' . $count_shops . '</strong></span>
                        </div>
                     ';
                  }
                  ?>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!--<div class="advertising-box-home" align="center">
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9873655553500142" data-ad-slot="6854705713" data-ad-format="auto"></ins>
      <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
   </div>-->

   <br>

   <div class="hide-for-small-only main-categories">
      <div class="mc-container" data-status="0">
         <?php
         if ($ads_categories) {
            $i = 1;
            $r = 1;

            echo '<div class="row" id="mc-row-' . $r . '">';

            foreach ($ads_categories as $key => $cat) {
               $sub_categories = $this->ads_model->categories($cat->ads_cat_id);

               echo '
               <div class="medium-3 end columns">
                  <div class="mc-box">
                     <h4>' . $cat->ads_cat_name . '</h4>
                     <ul>
            ';

               if ($sub_categories) {
                  foreach ($sub_categories as $key => $sub_cat) {
                     echo '<li><a targer="_self" href="' . base_url('anuncios/?categoria=' . $sub_cat->ads_cat_parent) . '">' . $sub_cat->ads_cat_name . '</a></li>';
                  }
               }

               echo '
                     </ul>
                  </div>
               </div>
            ';

               if ($i % 4 == 0) {
                  $r++;

                  echo '</div><div class="row" id="mc-row-' . $r . '">';
               }

               $i++;
            }

            echo '</div>';
         }
         ?>
      </div>
      <div class="row">
         <div class="medium-12 columns">
            <div class="mc-more-categories">
               <button type="button" id="mc-more-categories" data-text-close="ver menos" data-text-open="ver mais">ver mais</button>
            </div>
         </div>
      </div>
   </div>

   <script src="assets/js/custom/main.js"></script>
</div>
<div class="show-for-small-only">
   <div class="medium-12 large-8 columns">
      <div class="announce__header">
         <?php
         $slogan_mob = $this->main_model->config('cfg_slogan_mob');
         echo '
                     <h1>' . $slogan_mob . '</h1>
                    ';
         ?>
      </div><br>
      <div class="row">
         <div class="small-12 medium-6 columns">
            <a href="<?= base_url('anunciar') ?>" class="btn btn-block btn-secondary"><i class="fa fa-fw fa-tag"></i> Vender grátis</a>
         </div>
         <p align="center"><strong>Ou</strong>
            <p>
               <div class="small-12 medium-6 columns" align="right">
                  <a href="<?= base_url('anuncios') ?>" class="btn btn-block btn-primary"><i class="fa fa-fw fa-usd"></i> Comprar agora</a>
               </div>
               <br>
      </div>
      <div class="show-for-small-only">
         <div class="medium-12 large-8 columns">
            <div class="announce__header">
            </div>
            <div class="alert alert-subtitle">
               <div class="show-for-small-only">

                  <?php include "related.php"; ?>
                  <br>
               </div>
               <br>
            </div>
            <?= $this->main_model->advertisingBox('side') ?>