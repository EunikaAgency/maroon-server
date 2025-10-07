<?php

namespace TabItems\Locations;

class TabItem{
    
    public $name = "Locations";
    public $singularName = "Location";
    public $lowerCaseTabName = 'location';
    public $buttonId = 'location';
    public $tabClassName = "";
    public $priority = 100;

    public function tabData(){
        ob_start();
        ?>
        <div class="premium">This option is available for premium version only <span class="go_pro2"><a href="https://myrecorp.com/product/different-menus-in-different-pages/?clk=loc-tab&a=pro">Buy Now</a></span></div>

            <div style="filter: blur(0.5px);-webkit-filter: blur(0.5px);pointer-events: none;">
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AF]"><span class="flag flag-af"></span> Afghanistan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AX]"><span class="flag flag-ax"></span> Åland Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AL]"><span class="flag flag-al"></span> Albania</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[DZ]"><span class="flag flag-dz"></span> Algeria</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AS]"><span class="flag flag-as"></span> American Samoa</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AD]"><span class="flag flag-ad"></span> Andorra</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AO]"><span class="flag flag-ao"></span> Angola</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AI]"><span class="flag flag-ai"></span> Anguilla</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AQ]"><span class="flag flag-aq"></span> Antarctica</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AG]"><span class="flag flag-ag"></span> Antigua and Barbuda</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AR]"><span class="flag flag-ar"></span> Argentina</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AM]"><span class="flag flag-am"></span> Armenia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AW]"><span class="flag flag-aw"></span> Aruba</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AU]"><span class="flag flag-au"></span> Australia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AT]"><span class="flag flag-at"></span> Austria</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AZ]"><span class="flag flag-az"></span> Azerbaijan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BS]"><span class="flag flag-bs"></span> Bahamas</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BH]"><span class="flag flag-bh"></span> Bahrain</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BD]"><span class="flag flag-bd"></span> Bangladesh</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BB]"><span class="flag flag-bb"></span> Barbados</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BY]"><span class="flag flag-by"></span> Belarus</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BE]"><span class="flag flag-be"></span> Belgium</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BZ]"><span class="flag flag-bz"></span> Belize</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BJ]"><span class="flag flag-bj"></span> Benin</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BM]"><span class="flag flag-bm"></span> Bermuda</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BT]"><span class="flag flag-bt"></span> Bhutan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BO]"><span class="flag flag-bo"></span> Bolivia, Plurinational State of</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BQ]"><span class="flag flag-bq"></span> Bonaire, Sint Eustatius and Saba</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BA]"><span class="flag flag-ba"></span> Bosnia and Herzegovina</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BW]"><span class="flag flag-bw"></span> Botswana</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BV]"><span class="flag flag-bv"></span> Bouvet Island</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BR]"><span class="flag flag-br"></span> Brazil</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[IO]"><span class="flag flag-io"></span> British Indian Ocean Territory</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BN]"><span class="flag flag-bn"></span> Brunei Darussalam</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BG]"><span class="flag flag-bg"></span> Bulgaria</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BF]"><span class="flag flag-bf"></span> Burkina Faso</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BI]"><span class="flag flag-bi"></span> Burundi</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[KH]"><span class="flag flag-kh"></span> Cambodia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CM]"><span class="flag flag-cm"></span> Cameroon</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CA]"><span class="flag flag-ca"></span> Canada</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CV]"><span class="flag flag-cv"></span> Cape Verde</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[KY]"><span class="flag flag-ky"></span> Cayman Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CF]"><span class="flag flag-cf"></span> Central African Republic</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TD]"><span class="flag flag-td"></span> Chad</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CL]"><span class="flag flag-cl"></span> Chile</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CN]"><span class="flag flag-cn"></span> China</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CX]"><span class="flag flag-cx"></span> Christmas Island</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CC]"><span class="flag flag-cc"></span> Cocos (Keeling) Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CO]"><span class="flag flag-co"></span> Colombia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[KM]"><span class="flag flag-km"></span> Comoros</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CG]"><span class="flag flag-cg"></span> Congo</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CD]"><span class="flag flag-cd"></span> Congo, the Democratic Republic of the</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CK]"><span class="flag flag-ck"></span> Cook Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CR]"><span class="flag flag-cr"></span> Costa Rica</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CI]"><span class="flag flag-ci"></span> Côte d'Ivoire</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[HR]"><span class="flag flag-hr"></span> Croatia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CU]"><span class="flag flag-cu"></span> Cuba</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CW]"><span class="flag flag-cw"></span> Curaçao</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CY]"><span class="flag flag-cy"></span> Cyprus</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CZ]"><span class="flag flag-cz"></span> Czech Republic</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[DK]"><span class="flag flag-dk"></span> Denmark</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[DJ]"><span class="flag flag-dj"></span> Djibouti</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[DM]"><span class="flag flag-dm"></span> Dominica</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[DO]"><span class="flag flag-do"></span> Dominican Republic</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[EC]"><span class="flag flag-ec"></span> Ecuador</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[EG]"><span class="flag flag-eg"></span> Egypt</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SV]"><span class="flag flag-sv"></span> El Salvador</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GQ]"><span class="flag flag-gq"></span> Equatorial Guinea</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[ER]"><span class="flag flag-er"></span> Eritrea</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[EE]"><span class="flag flag-ee"></span> Estonia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[ET]"><span class="flag flag-et"></span> Ethiopia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[FK]"><span class="flag flag-fk"></span> Falkland Islands (Malvinas)</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[FO]"><span class="flag flag-fo"></span> Faroe Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[FJ]"><span class="flag flag-fj"></span> Fiji</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[FI]"><span class="flag flag-fi"></span> Finland</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[FR]"><span class="flag flag-fr"></span> France</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GF]"><span class="flag flag-gf"></span> French Guiana</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PF]"><span class="flag flag-pf"></span> French Polynesia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TF]"><span class="flag flag-tf"></span> French Southern Territories</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GA]"><span class="flag flag-ga"></span> Gabon</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GM]"><span class="flag flag-gm"></span> Gambia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GE]"><span class="flag flag-ge"></span> Georgia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[DE]"><span class="flag flag-de"></span> Germany</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GH]"><span class="flag flag-gh"></span> Ghana</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GI]"><span class="flag flag-gi"></span> Gibraltar</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GR]"><span class="flag flag-gr"></span> Greece</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GL]"><span class="flag flag-gl"></span> Greenland</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GD]"><span class="flag flag-gd"></span> Grenada</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GP]"><span class="flag flag-gp"></span> Guadeloupe</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GU]"><span class="flag flag-gu"></span> Guam</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GT]"><span class="flag flag-gt"></span> Guatemala</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GG]"><span class="flag flag-gg"></span> Guernsey</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GN]"><span class="flag flag-gn"></span> Guinea</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GW]"><span class="flag flag-gw"></span> Guinea-Bissau</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GY]"><span class="flag flag-gy"></span> Guyana</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[HT]"><span class="flag flag-ht"></span> Haiti</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[HM]"><span class="flag flag-hm"></span> Heard Island and McDonald Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[VA]"><span class="flag flag-va"></span> Holy See (Vatican City State)</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[HN]"><span class="flag flag-hn"></span> Honduras</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[HK]"><span class="flag flag-hk"></span> Hong Kong</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[HU]"><span class="flag flag-hu"></span> Hungary</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[IS]"><span class="flag flag-is"></span> Iceland</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[IN]"><span class="flag flag-in"></span> India</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[ID]"><span class="flag flag-id"></span> Indonesia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[IR]"><span class="flag flag-ir"></span> Iran, Islamic Republic of</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[IQ]"><span class="flag flag-iq"></span> Iraq</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[IE]"><span class="flag flag-ie"></span> Ireland</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[IM]"><span class="flag flag-im"></span> Isle of Man</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[IT]"><span class="flag flag-it"></span> Italy</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[JM]"><span class="flag flag-jm"></span> Jamaica</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[JP]"><span class="flag flag-jp"></span> Japan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[JE]"><span class="flag flag-je"></span> Jersey</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[JO]"><span class="flag flag-jo"></span> Jordan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[KZ]"><span class="flag flag-kz"></span> Kazakhstan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[KE]"><span class="flag flag-ke"></span> Kenya</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[KI]"><span class="flag flag-ki"></span> Kiribati</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[KP]"><span class="flag flag-kp"></span> Korea, Democratic People's Republic of</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[KR]"><span class="flag flag-kr"></span> Korea, Republic of</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[KW]"><span class="flag flag-kw"></span> Kuwait</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[KG]"><span class="flag flag-kg"></span> Kyrgyzstan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[LA]"><span class="flag flag-la"></span> Lao People's Democratic Republic</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[LV]"><span class="flag flag-lv"></span> Latvia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[LB]"><span class="flag flag-lb"></span> Lebanon</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[LS]"><span class="flag flag-ls"></span> Lesotho</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[LR]"><span class="flag flag-lr"></span> Liberia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[LY]"><span class="flag flag-ly"></span> Libya</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[LI]"><span class="flag flag-li"></span> Liechtenstein</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[LT]"><span class="flag flag-lt"></span> Lithuania</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[LU]"><span class="flag flag-lu"></span> Luxembourg</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MO]"><span class="flag flag-mo"></span> Macao</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MK]"><span class="flag flag-mk"></span> Macedonia, the former Yugoslav Republic of</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MG]"><span class="flag flag-mg"></span> Madagascar</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MW]"><span class="flag flag-mw"></span> Malawi</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MY]"><span class="flag flag-my"></span> Malaysia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MV]"><span class="flag flag-mv"></span> Maldives</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[ML]"><span class="flag flag-ml"></span> Mali</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MT]"><span class="flag flag-mt"></span> Malta</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MH]"><span class="flag flag-mh"></span> Marshall Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MQ]"><span class="flag flag-mq"></span> Martinique</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MR]"><span class="flag flag-mr"></span> Mauritania</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MU]"><span class="flag flag-mu"></span> Mauritius</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[YT]"><span class="flag flag-yt"></span> Mayotte</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MX]"><span class="flag flag-mx"></span> Mexico</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[FM]"><span class="flag flag-fm"></span> Micronesia, Federated States of</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MD]"><span class="flag flag-md"></span> Moldova, Republic of</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MC]"><span class="flag flag-mc"></span> Monaco</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MN]"><span class="flag flag-mn"></span> Mongolia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[ME]"><span class="flag flag-me"></span> Montenegro</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MS]"><span class="flag flag-ms"></span> Montserrat</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MA]"><span class="flag flag-ma"></span> Morocco</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MZ]"><span class="flag flag-mz"></span> Mozambique</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MM]"><span class="flag flag-mm"></span> Myanmar</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NA]"><span class="flag flag-na"></span> Namibia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NR]"><span class="flag flag-nr"></span> Nauru</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NP]"><span class="flag flag-np"></span> Nepal</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NL]"><span class="flag flag-nl"></span> Netherlands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NC]"><span class="flag flag-nc"></span> New Caledonia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NZ]"><span class="flag flag-nz"></span> New Zealand</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NI]"><span class="flag flag-ni"></span> Nicaragua</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NE]"><span class="flag flag-ne"></span> Niger</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NG]"><span class="flag flag-ng"></span> Nigeria</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NU]"><span class="flag flag-nu"></span> Niue</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NF]"><span class="flag flag-nf"></span> Norfolk Island</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MP]"><span class="flag flag-mp"></span> Northern Mariana Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[NO]"><span class="flag flag-no"></span> Norway</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[OM]"><span class="flag flag-om"></span> Oman</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PK]"><span class="flag flag-pk"></span> Pakistan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PW]"><span class="flag flag-pw"></span> Palau</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PS]"><span class="flag flag-ps"></span> Palestinian Territory, Occupied</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PA]"><span class="flag flag-pa"></span> Panama</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PG]"><span class="flag flag-pg"></span> Papua New Guinea</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PY]"><span class="flag flag-py"></span> Paraguay</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PE]"><span class="flag flag-pe"></span> Peru</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PH]"><span class="flag flag-ph"></span> Philippines</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PN]"><span class="flag flag-pn"></span> Pitcairn</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PL]"><span class="flag flag-pl"></span> Poland</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PT]"><span class="flag flag-pt"></span> Portugal</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PR]"><span class="flag flag-pr"></span> Puerto Rico</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[QA]"><span class="flag flag-qa"></span> Qatar</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[RE]"><span class="flag flag-re"></span> Réunion</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[RO]"><span class="flag flag-ro"></span> Romania</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[RU]"><span class="flag flag-ru"></span> Russian Federation</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[RW]"><span class="flag flag-rw"></span> Rwanda</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[BL]"><span class="flag flag-bl"></span> Saint Barthélemy</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SH]"><span class="flag flag-sh"></span> Saint Helena, Ascension and Tristan da Cunha</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[KN]"><span class="flag flag-kn"></span> Saint Kitts and Nevis</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[LC]"><span class="flag flag-lc"></span> Saint Lucia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[MF]"><span class="flag flag-mf"></span> Saint Martin (French part)</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[PM]"><span class="flag flag-pm"></span> Saint Pierre and Miquelon</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[VC]"><span class="flag flag-vc"></span> Saint Vincent and the Grenadines</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[WS]"><span class="flag flag-ws"></span> Samoa</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SM]"><span class="flag flag-sm"></span> San Marino</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[ST]"><span class="flag flag-st"></span> Sao Tome and Principe</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SA]"><span class="flag flag-sa"></span> Saudi Arabia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SN]"><span class="flag flag-sn"></span> Senegal</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[RS]"><span class="flag flag-rs"></span> Serbia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SC]"><span class="flag flag-sc"></span> Seychelles</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SL]"><span class="flag flag-sl"></span> Sierra Leone</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SG]"><span class="flag flag-sg"></span> Singapore</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SX]"><span class="flag flag-sx"></span> Sint Maarten (Dutch part)</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SK]"><span class="flag flag-sk"></span> Slovakia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SI]"><span class="flag flag-si"></span> Slovenia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SB]"><span class="flag flag-sb"></span> Solomon Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SO]"><span class="flag flag-so"></span> Somalia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[ZA]"><span class="flag flag-za"></span> South Africa</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GS]"><span class="flag flag-gs"></span> South Georgia and the South Sandwich Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SS]"><span class="flag flag-ss"></span> South Sudan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[ES]"><span class="flag flag-es"></span> Spain</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[LK]"><span class="flag flag-lk"></span> Sri Lanka</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SD]"><span class="flag flag-sd"></span> Sudan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SR]"><span class="flag flag-sr"></span> Suriname</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SJ]"><span class="flag flag-sj"></span> Svalbard and Jan Mayen</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SZ]"><span class="flag flag-sz"></span> Swaziland</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SE]"><span class="flag flag-se"></span> Sweden</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[CH]"><span class="flag flag-ch"></span> Switzerland</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[SY]"><span class="flag flag-sy"></span> Syrian Arab Republic</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TW]"><span class="flag flag-tw"></span> Taiwan, Province of China</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TJ]"><span class="flag flag-tj"></span> Tajikistan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TZ]"><span class="flag flag-tz"></span> Tanzania, United Republic of</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TH]"><span class="flag flag-th"></span> Thailand</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TL]"><span class="flag flag-tl"></span> Timor-Leste</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TG]"><span class="flag flag-tg"></span> Togo</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TK]"><span class="flag flag-tk"></span> Tokelau</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TO]"><span class="flag flag-to"></span> Tonga</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TT]"><span class="flag flag-tt"></span> Trinidad and Tobago</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TN]"><span class="flag flag-tn"></span> Tunisia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TR]"><span class="flag flag-tr"></span> Turkey</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TM]"><span class="flag flag-tm"></span> Turkmenistan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TC]"><span class="flag flag-tc"></span> Turks and Caicos Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[TV]"><span class="flag flag-tv"></span> Tuvalu</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[UG]"><span class="flag flag-ug"></span> Uganda</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[UA]"><span class="flag flag-ua"></span> Ukraine</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[AE]"><span class="flag flag-ae"></span> United Arab Emirates</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[GB]"><span class="flag flag-gb"></span> United Kingdom</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[US]"><span class="flag flag-us"></span> United States</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[UM]"><span class="flag flag-um"></span> United States Minor Outlying Islands</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[UY]"><span class="flag flag-uy"></span> Uruguay</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[UZ]"><span class="flag flag-uz"></span> Uzbekistan</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[VU]"><span class="flag flag-vu"></span> Vanuatu</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[VE]"><span class="flag flag-ve"></span> Venezuela, Bolivarian Republic of</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[VN]"><span class="flag flag-vn"></span> Viet Nam</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[VG]"><span class="flag flag-vg"></span> Virgin Islands, British</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[VI]"><span class="flag flag-vi"></span> Virgin Islands, U.S.</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[WF]"><span class="flag flag-wf"></span> Wallis and Futuna</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[EH]"><span class="flag flag-eh"></span> Western Sahara</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[YE]"><span class="flag flag-ye"></span> Yemen</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[ZM]"><span class="flag flag-zm"></span> Zambia</label>
                <label><input type="checkbox" name="<?php echo esc_attr($this->lowerCaseTabName); ?>[ZW]"><span class="flag flag-zw"></span> Zimbabwe</label>
            </div>
        <?php

        $output = ob_get_clean();
        
        return $output;
    }
}


    