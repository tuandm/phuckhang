<?php
    wp_enqueue_script('jquery-cycle2', get_template_directory_uri() . '/js/jquery.cycle2.min.js', array(), '2.1.6', true);
    wp_enqueue_script('jquery-cycle2-scrollVert', get_template_directory_uri() . '/js/jquery.cycle2.scrollVert.min.js', array('jquery-cycle2'), '2.1.6', true);
    get_header();
?>
  <div class="project-banner langsen">
    <div class="banner-info">
      <span class="banner-sub">Dự Án</span>
      <span class="banner-title">Làng Sen Việt Nam</span>
      <span class="banner-link"><a href="http://www.langsenvietnam.vn">www.langsenvietnam.vn</a></span>
    </div>
  </div>

<div class="content">

  <div class="sub-nav-wrap col-lg-2 col-lg-offset-1">
    <ul class="sub-nav sub-nav-project-detail">
      <li class="active"><a href="javascript:;">Giới Thiệu</a></li>
      <li><a href="javascript:;">Quy Mô</a></li>
      <li><a href="javascript:;">Hình Ảnh Thực Tế</a></li>
      <li><a href="javascript:;">Vị Trí</a></li>
      <li><a href="javascript:;">Mở Bán</a></li>
      <li><a href="javascript:;">Dự án khác</a></li>
    </ul>

    <div class="hotline">
      <span>
        hotline <br />
        <strong><a href="tel:+840873001345">(+84) 08 730 01 345</a></strong>
      </span>
    </div>


  </div>

  <div class="project-detail-content col-lg-7">

    <div class="project-detail-slider cycle-slideshow col-lg-12"
         data-cycle-fx="scrollVert"
         data-cycle-timeout="0"
         data-cycle-speed="600"
         data-cycle-pager=".sub-nav-project-detail"
         data-cycle-pager-template=""
         data-cycle-slides="> div.project-detail"
    >
        <div id="intro" class="project-detail">

          <h2 class="sub-header">Giới Thiệu</h2>

          <strong>Nơi hàng triệu người muốn đến, hàng ngàn người mong về!</strong>
          <p>Thiết kế của Làng Sen Việt Nam là sự giao thoa của các tinh hoa văn hoá dân tộc. Ý tưởng thiết kế được lấy từ sự kết hợp giữa mặt trống đồng Đông Sơn với những nét hoa văn tinh xảo cùng một lá sen đang căng tràn sức sống để làm nên một khu đô thị văn hóa – thương mại đậm nét truyển thống, nơi con cháu đất Việt nhớ về nguồn cội 4000 năm văn hiến.</p>

          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/langsen/langsen1.jpg" height="243" width="588" class="project-img img-responsive">

          <strong>Khoản đầu tư thông minh từ trái tim!</strong>
          <p>Nằm liền kề trung tâm TP.HCM, Làng Sen Việt Nam sở hữu một vị trí thuận lợi cho mọi nhu cầu Đầu Tư - An cư - Nghỉ dưỡng nhưng lại thật dễ dàng để sở hữu chỉ với 20 phút di chuyển theo hướng từ vòng xoay Phú Lâm hoặc Đại lộ Võ Văn Kiệt theo đường Trần Văn Giàu, Trần Đại Nghĩa. Từ Làng Sen Việt Nam, chúng ta dễ dàng di chuyển vào Chợ Lớn, Quận 1 hay Sân bay Tân Sơn Nhất, đặc biệt để đến các tiện ích xung quanh như Bến xe Miền Tây - Siêu thị Co.op Mart, bệnh viện, trung tâm hành chính, trường học các cấp chỉ mất 10 phút.</p>

          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/langsen/langsen2.jpg" height="328" width="587" class="project-img img-responsive">

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
            <h2 class="sub-header">Vị Trí</h2>

             <p>Làng Sen Việt Nam là một sản phẩm của Phúc Khang Corporation, tọa lạc tại huyện Đức Hòa, tỉnh Long An, nằm gần khu trung tâm hành chính cận kề, hệ thống trường học các cấp, bệnh viện, siêu thị, chợ An Hạ…, chỉ cách trung tâm TP HCM khoảng 30 phút di chuyển.</p>

            <p>Dự án rộng hơn 50ha, được thiết kế với những điểm nhấn kiến trúc gợi nhớ nét văn hóa vùng miền từ đồng bằng sông Hồng, dải đất miền Trung cho đến đồng bằng sông Cửu Long.</p>

            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/project/langsen/location.jpg" height="328" width="587" class="project-img img-responsive">

            <p>Nếu như khu thương mại Nam Bộ nổi bật với không gian mở hình con thuyền, làng nổi và hàng dừa rợp bóng đan xen thì khu miền Trung duyên dáng với mái hiên đầy hoa giấy trên dãy tường phố mang màu vàng đặc trưng của kiến trúc Hội An. Còn khu thương mại Bắc Bộ mang nét riêng với sân trong, cây đa, giếng nước.</p>

        </div>

        <div id="onsale" class="project-detail">
            <h2 class="sub-header">Mở Bán</h2>

            <table class="table table-hover onsale-table">
              <thead>
                <tr>
                  <th>
                    <input type="text" name="code" id="code" class="form-control" value="" pattern="" title=""><br />
                    Mã số
                  </th>
                  <th>
                      <select name="price" id="price" class="form-control" required="required">
                        <option value="">Giá</option>
                        <option value="">450,644,555</option>
                        <option value="">500,644,555</option>
                        <option value="">618,297,547</option>
                      </select>
                    <br />
                    Giá
                    </th>
                  <th>
                    <select name="status" id="status" class="form-control" required="required">
                      <option value="">Tình Trạng</option>
                      <option value="">Khuyến mãi</option>
                      <option value="">Đã bán</option>
                      <option value="">Còn hàng</option>
                    </select>
                    <br />
                    Tình Trạng
                  </th>
                  <th>
                    <select name="status" id="status" class="form-control" required="required">
                      <option value="">Diện Tích</option>
                      <option value="">50m2</option>
                      <option value="">60m2</option>
                      <option value="">70m2</option>
                    </select>
                    <br />
                    Diện Tích
                    </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                    <?php $products = LandBook_Projects::getInstance()->listProducts();
                    function getProductStatus($value)
                    {
                        switch ($value) {
                            case '3' :
                                return 'Khuyến Mãi';
                            case '2' :
                                return 'Đã Bán';
                            case '1' :
                                return 'Đang Đặt';
                        }
                    }
                    ?>
                    <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo $product->code; ?></td>
                    <td><?php echo $product->price; ?></td>
                    <td><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/promotion-icon.png" height="20" width="20" class="icon"><?php echo getProductStatus($product->status); ?></td>
                    <td><?php echo $product->area; ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
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
