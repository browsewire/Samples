 <!-- footer starts -->
  <div id="fooeter">
    <div class="wrapper">
      <div class="wrapper_main">
        <footer>
          <div class="footer_top">
            <ul>
              <li>
              <h3>Online USA Doctors</h3>
                <ul>
                  <li>
					  <?php
					  $getAdd=explode(",",$this->options->getData('address'));
					  ?>
					  <?=$getAdd['0']?> , <?=$getAdd['1']?> <br>
					   <?=$getAdd['2']?><br>
					 
						Phone no - <?=$this->options->getData('mobile_no')?><br>
						Email id - <?=$this->options->getData('address_email')?>
                  </li>
                </ul>
              </li>
              <li>
              <h3>ABOUT US</h3>
                <ul>
                  <li><a href="index.html">Home</a></li>
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Site Map</a></li>
                  <li><a href="#">Contact Us</a></li>
                </ul>
              </li>
               <li>
              <h3>SERVICES</h3>
                <ul>
                  <li><a href="<?=base_url()?>symptom-checker">Symptom Checker</a></li>
                   <li><a href="<?=base_url()?>healthy-living">Healthy Living</a></li>
                   <li><a href="<?=base_url()?>pharma-grade-supplements">Pharma-Grade Supplements</a></li>
                  <li><a href="<?=base_url()?>lab-tests">Lab Tests</a></li>
                  <li><a href="<?=base_url()?>haq">HAQ</a></li>
                  <li><a href="http://shop.onlineusadoctors.com">Wellness Store</a></li>
                  <li><a href="<?=base_url()?>online-health-chart">Online Health Chart</a></li>
                   <li><a href="<?=base_url()?>qa">Ask The Doctor</a></li>
                </ul>
              </li>
              <li>
              <h3>&nbsp;</h3>
                <ul>
                   <li><a href="<?=base_url()?>plan">Enroll and create your account</a></li>
                   <li><a href="<?=base_url()?>plan">Schedule an appointment</a></li>
                   <li><a href="<?=base_url()?>plan">Consult with doctor</a></li>
                </ul>
              </li>
              
              <li>
              <h3>Customer Service</h3>
                <ul>
                  <li>24x7 Available</li>
                  <li>Help</li>
                  <li>Customer Service</li>
                  <li><a href="<?=base_url()?>sitemap">Site Map</a></li>
                  <li><a href="<?=base_url()?>contact-us">Contact Us</a></li>
                </ul>
              <ul class="footer_bottom01"> 
              <h3>Follow Us On</h3>
                <li style="clear:both !important;"><a href="https://facebook.com/OnlineUsaDoctors" class="facebook">&nbsp;</a></li>
                <li><a href="https://plus.google.com/117055039382506547720" class="google">&nbsp;</a></li>
                <!--<li><a href="#" class="pinterest">&nbsp;</a></li>-->
                <li><a href="https://twitter.com/OnlineUSADoctor" class="twitter">&nbsp;</a></li>
              </ul>
              </li>
            </ul>
          </div>
          <div class="footer_bottom">
            <div class="footer_bottom02">
              <ul>
                <li><a href="<?=base_url()?>terms">Terms & Conditions</a></li>
                <li><a href="<?=base_url()?>sitemap">Site Map</a></li>
                <li>&copy; Copyright 2013 OnlineUSADoctors. All rights reserved.</li>
              </ul>
            </div>
            <div class="footer_bottom03">
              Powered By <a href="http://www.browsewire.net">&nbsp;</a>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </div>
  <!-- footer ends -->
</div>

<!-- wrapper ends -->

<!--start of Offerchat js code-->
<script type='text/javascript'>var ofc_key = 'a52c2fa25535694633928b3dbe0cc889';(function(){  var oc = document.createElement('script'); oc.type = 'text/javascript'; oc.async = true;  oc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'www.offerchat.com/offerchat_widget.min.js?r='+ Math.random();  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(oc, s);}());</script>
<!--end of Offerchat js code-->
</body>
</html>
