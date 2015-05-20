<?php
    wp_enqueue_script('jquery-cycle2', get_template_directory_uri() . '/js/jquery.cycle2.min.js', array(), '2.1.6', true);
    wp_enqueue_script('jquery-cycle2-scrollVert', get_template_directory_uri() . '/js/jquery.cycle2.scrollVert.min.js', array('jquery-cycle2'), '2.1.6', true);
    get_header();
?>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/jquery.dataTables.css">
<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="<?php echo get_template_directory_uri(); ?>/js/jquery.dataTables.min.js"></script>
<div class="project-banner langsen">
    <div class="banner-info">
      <span class="banner-sub">Dự Án</span>
      <span class="banner-title">Làng Sen Việt Nam</span>
      <span class="banner-link"><a href="http://www.langsenvietnam.vn">www.langsenvietnam.vn</a></span>
    </div>
  </div>

<div class="content">

  <div class="sub-nav-wrap col-lg-2">
    <ul class="sub-nav sub-nav-project-detail">
      <li class="active"><a href="javascript:;">Giới Thiệu</a></li>
      <li><a href="javascript:;">Quy Mô</a></li>
      <li><a href="javascript:;">Hình Ảnh Thực Tế</a></li>
      <li><a href="javascript:;">Vị Trí</a></li>
      <li><a href="javascript:;">Mở Bán</a></li>
    </ul>

    <div class="hotline">
      <span>
        hotline <br />
        <strong><a href="tel:+840873001345">(+84) 08 730 01 345</a></strong>
      </span>
    </div>

    <div class="map-link">
      <a href="#">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/btn-xem-ban-do.png" height="81" width="198" alt="Xem bản  đồ">
      </a>
    </div>

  </div>

  <div class="project-detail-content col-lg-10">

    <div class="project-detail-slider cycle-slideshow col-lg-12"
         data-cycle-fx="scrollVert"
         data-cycle-timeout="0"
         data-cycle-speed="600"
         data-cycle-pager=".sub-nav-project-detail"
         data-cycle-pager-template=""
         data-cycle-slides="> div.project-detail"
    >
        <div id="intro" class="project-detail">

          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="intro-header">
              <div class="intro-content col-lg-6 col-xs-12">
                <h2>MỘT Ý TƯỞNG TỪ</h2>
                <p>
                    Nhớ về nguồn cội hơn bốn nghìn năm văn hiến <br />
                    Nhớ về một loài hoa mộc mạc, thanh bần.<br />
                    Nhưng rất đỗi cao quí, mang quốc hồn quốc túy<br />
                    Niềm tự hào dân tộc Việt.<br />
                </p>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>

          <div class="project-info-wrap">
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                <img class="author-img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/langsen/vo-trong-nghia.png" height="152" width="152" alt="KTS. Võ Trọng Nghĩa">
              </div>

              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <p>
                  <span class="author-name">KTS. VÕ TRỌNG NGHĨA</span>
                  <br />
                  <span class="author-bio">
                    Niềm tự hào của kiến trúc Việt Nam. <br />
                    Với các dự án xanh tầm cỡ thế giới.<br />
                  </span>
                </p>
              </div>

              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <p class="project-intro">Thiết kế của Làng Sen Việt Nam là sự giao thoa của các tinh hoa văn hoá dân tộc. Ý tưởng thiết kế được lấy từ sự kết hợp giữa mặt trống đồng Đông Sơn với những nét hoa văn tinh xảo cùng một lá sen đang căng tràn sức sống để làm nên một khu đô thị văn hóa – thương mại đậm nét truyển thống, nơi con cháu đất Việt nhớ về nguồn cội 4000 năm văn hiến.</p>
              </div>
            </div>
          </div>

        </div>

        <div id="scale" class="project-detail">
            <h2 class="sub-header">Quy Mô</h2>
            <p>Với quy mô rộng hơn 50ha, tổng mức đầu tư dự kiến 1.000 tỷ đồng, dự án khu đô thị văn hóa - thương mại - du lịch Làng Sen Việt Nam sẽ mang nét kiến trúc mô phỏng văn hóa đặc trưng cả ba miền Bắc, Trung, Nam.</p>
            <p>Làng Sen Việt Nam là một sản phẩm của Phuc Khang Corporation, tọa lạc tại huyện Đức Hòa, tỉnh Long An, nằm gần khu trung tâm hành chính cận kề, hệ thống trường học các cấp, bệnh viện, siêu thị, chợ An Hạ..., chỉ cách trung tâm TP HCM khoảng 30 phút di chuyển. Để tìm hiểu thêm thông tin, vui lòng truy cập vào website chính của dự án theo địa chỉ sau: www.langsenvietnam.vn</p>
        </div>

        <div id="picture" class="project-detail">
            <h2 class="sub-header">Hình ảnh thực tế</h2>
            <div id="picture-slide"
                class="cycle-slideshow"
                data-cycle-fx="scrollHorz"
                data-cycle-timeout="4000"
                data-cycle-pager="#slide-pager"
                data-cycle-pager-template="<li class='slide-nav'><a href=#></a></li>"
                >

              <div class="cycle-prev"></div>
              <div class="cycle-next"></div>

              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/langsen/picture1.jpg" height="449" width="631" class="img-responsive">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/langsen/picture2.jpg" height="449" width="629" class="img-responsive">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/langsen/picture3.jpg" height="449" width="631" class="img-responsive">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/langsen/picture4.jpg" height="449" width="629" class="img-responsive">
            </div>

            <div class="slide-pager-wrap">
              <ol id="slide-pager" class="project-indicators">
              </ol>
            </div>

            <p class="quote">Các dãy phố được quy hoạch hiện đại. Được thổi hồn từ một ý tưởng giàu nhân văn, truyền thống, mỗi ngôi nhà được thiết kế thật mộc mạc, thân thiện với môi trường và tiết kiệm chi phí xây dựng.</p>
        </div>

        <div id="location" class="project-detail">
          <div class="location-info-wrap">

              <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <p class="location-em">Toạ lạc tại huyện Đức Hoà, Long An, dự án Làng Sen Việt Nam chỉ cách trung tâm TPHCM 30 phút đi xe. Chính vì vậy, dự án Làng Sen Việt Nam được dự đoán sẽ trở thành điểm đến mới của người Sài Gòn bởi những giá trị văn hoá, cộng đồng mà nó mang lại.</p>

                <p>Nằm liền kề trung tâm TP.HCM, Làng Sen Việt Nam sở hữu một vị trí thuận lợi cho mọi nhu cầu Đầu Tư – An cư – Nghỉ dưỡng nhưng lại thật dễ dàng để sở hữu chỉ với 20 phút di chuyển theo hướng từ vòng xoay Phú Lâm hoặc Đại lộ Võ Văn Kiệt theo đường Trần Văn Giàu, Trần Đại Nghĩa. </p>

                <p>Từ Làng Sen Việt Nam, chúng ta dễ dàng di chuyển vào Chợ Lớn, Quận 1 hay Sân bay Tân Sơn Nhất, đặc biệt để đến các tiện ích xung quanh như Bến xe Miền Tây – Siêu thị Co.op Mart, bệnh viện, trung tâm hành chính, trường học các cấp chỉ mất 10 phút.</p>

                <p>
                  <a href="#">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/btn-xem.png" height="42" width="176">
                  </a>
                </p>
              </div>

            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
               <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/langsen/location.jpg" height="420" width="449">
            </div>

          </div>


        </div>

        <div id="onsale" class="project-detail">
            <h2 class="sub-header">Mở Bán</h2>
            <table class="table table-hover onsale-table">
                <?php $projectId = get_post_meta( get_the_ID(), 'projectId', true ); ?>
                <input type="hidden" id="projectId" name="projectId" value="<?php echo $projectId; ?>">
                <table id="products" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Mã Số</th>
                            <th>Giá</th>
                            <th>Tình Trạng</th>
                            <th>Diện Tích</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Mã Số</th>
                            <th>Giá</th>
                            <th>Tình Trạng</th>
                            <th>Diện Tích</th>
                        </tr>
                        </tfoot>
                    <?php $products = LandBook_Ajax::getInstance()->listProducts($projectId); ?>
                    <tbody>
                    <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo $product->code; ?></td>
                        <td><?php echo $product->price; ?></td>
                        <td><?php echo $product->status; ?></td>
                        <td><?php echo $product->area; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </table>
        </div>

        <div id="other-projects" class="project-detail">
          <h2 class="sub-header">Dự Án Khác</h2>

          <div id="others-slide"
                class="cycle-slideshow"
                data-cycle-fx="scrollVert"
                data-cycle-timeout="4000"
                data-cycle-pager="#slide-pager2"
                data-cycle-pager-template="<li class='slide-nav'><a href=#></a></li>"
                data-cycle-slides="> div.project-slide"
                >

              <div class="project-slide">
                <div class="other-project-wrap">
                  <div class="other-project-header">
                    <span class="project-sub">Dự Án</span>
                    <span class="project-title">Eco Village</span>
                    <span class="project-link"><a href="http://www.langsenvietnam.vn">www.ecovillage.vn</a></span>
                  </div>
                  <a href="#" class="other-project-link">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/ecovillage_thumb.jpg" height="176" width="304" class="img-responsive">
                  </a>
                </div>

                <div class="other-project-wrap">
                  <div class="other-project-header">
                    <span class="project-sub">Dự Án</span>
                    <span class="project-title">Eco Sun</span>
                    <span class="project-link"><a href="http://www.langsenvietnam.vn">www.ecosun.vn</a></span>
                  </div>
                  <a href="#" class="other-project-link">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/ecosun_thumb.jpg" height="176" width="304" class="img-responsive">
                  </a>
                </div>
              </div><!-- /.slide  -->

              <div class="project-slide">
                <div class="other-project-wrap">
                  <div class="other-project-header">
                    <span class="project-sub">Dự Án</span>
                    <span class="project-title">Làng Sen Việt Nam</span>
                    <span class="project-link"><a href="http://www.langsenvietnam.vn">www.langsenvietnam.vn</a></span>
                  </div>
                  <a href="#" class="other-project-link">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/ecosun_thumb.jpg" height="176" width="304" class="img-responsive">
                  </a>
                </div>

                <div class="other-project-wrap">
                  <div class="other-project-header">
                    <span class="project-sub">Dự Án</span>
                    <span class="project-title">Sun Flower</span>
                    <span class="project-link"><a href="http://www.langsenvietnam.vn">www.ecosun.vn</a></span>
                  </div>
                  <a href="#" class="other-project-link">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/ecovillage_thumb.jpg" height="176" width="304" class="img-responsive">
                  </a>
                </div>
              </div><!-- /.slide  -->

          </div>

          <div class="clearfix"></div>

          <div class="slide-pager-wrap">
              <ol id="slide-pager2" class="project-indicators">
              </ol>
          </div>

        </div>
        <!-- /other-projects -->

    </div>

  </div>

</div>
<?php get_footer(); ?>
