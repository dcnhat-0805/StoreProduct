<!-- product left -->
<input type="hidden" class="description" value="{{ $slug }}">
<div class="side-bar col-sm-12">
    <!-- price range -->
    <div class="range">
        <h3 class="agileits-sear-head">Price range</h3>
        <ul class="dropdown-menu6">
            <li>

                <div id="slider-range"></div>
                <input type="text" id="amount" style="border: 0; color: #ffffff; font-weight: normal;"/>
            </li>
        </ul>
    </div>
    <!-- Location -->
    <div class="left-side">
        <h3 class="agileits-sear-head">Location</h3>
        <ul>
            <li>
                <input type="checkbox" class="jsCheckBox" id="local" name="local" value="local"
                       data-href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => $slug, 'location' => 1]) }}">
                <label for="local" class="label__span">Local</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox" id="overseas">
                <label for="overseas" class="label__span">Overseas</label>
            </li>
        </ul>
    </div>
    <!-- Brand -->
    <div class="left-side">
        <h3 class="agileits-sear-head">Brand</h3>
        <ul>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Apple</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">SamSung</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Oppo</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Xiaomi</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Nokia</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Sony</label>
            </li>
        </ul>
    </div>
    <!-- Service -->
    <div class="left-side">
        <h3 class="agileits-sear-head">Service</h3>
        <ul>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Free Shipping</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Global Collection</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Cash On Delivery</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Fulfilled By StoreOnline</label>
            </li>
        </ul>
    </div>
    <!-- discounts -->
    <div class="left-side">
        <h3 class="agileits-sear-head">Discount</h3>
        <ul>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">5% or More</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">10% or More</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">20% or More</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">30% or More</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">50% or More</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">60% or More</label>
            </li>
        </ul>
    </div>
    <!-- Storage Capacity -->
    <div class="left-side">
        <h3 class="agileits-sear-head">Storage Capacity</h3>
        <ul>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Below 1 GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">2 GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">4 GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">8 GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">16 GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">32 GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">64 GB</label>
            </li>
        </ul>
    </div>
    <!-- Network Connections -->
    <div class="left-side">
        <h3 class="agileits-sear-head">Network Connections</h3>
        <ul>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">2G</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">2G - EDGE</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">2G - GPRS</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">3G</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">16 GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">3G - UMTS</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">4G</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">4G - LTE</label>
            </li>
        </ul>
    </div>
    <!-- Color Family -->
    <div class="left-side">
        <h3 class="agileits-sear-head">Color Family</h3>
        <ul>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Black</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Gold</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">White</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Yellow</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Blue</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Red</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Purple</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Grey</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Silver</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Multicolor</label>
            </li>
        </ul>
    </div>
    <!-- Phone Features -->
    <div class="left-side">
        <h3 class="agileits-sear-head">Phone Features</h3>
        <ul>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Expandable Memory</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Touchscreen</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">GPS</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Fingerprint Sensor</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Dustproof / Waterproof</label>
            </li>
        </ul>
    </div>
    <!-- Phone Screen Size -->
    <div class="left-side">
        <h3 class="agileits-sear-head">Phone Screen Size</h3>
        <ul>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">More than 5.6 Inch</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">5.1 - 5.5 Inch</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">4.6 - 5 Inch</label>
            </li>
        </ul>
    </div>
    <!-- Battery Capacity -->
    <div class="left-side">
        <h3 class="agileits-sear-head">Battery Capacity</h3>
        <ul>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">1000 mAh to 5000 mAh</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">3000 - 3999 mAh</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">2000 - 2999 mAh</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Under 1000 mAh</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">Under 1000 mAh</label>
            </li>
        </ul>
    </div>
    <!-- RAM memory -->
    <div class="left-side">
        <h3 class="agileits-sear-head">RAM memory</h3>
        <ul>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">1GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">2GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">3GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">4GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">6GB</label>
            </li>
            <li>
                <input type="checkbox" class="jsCheckBox">
                <label class="label__span">8GB</label>
            </li>
        </ul>
    </div>
    <!-- Rating -->
    <div class="customer-rev left-side">
        <h3 class="agileits-sear-head">Rating</h3>
        <ul>
            <li>
                <a href="#">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <label>5.0</label>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <label>4.0</label>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <label>3.5</label>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <label>3.0</label>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <label>2.5</label>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- //product left -->
