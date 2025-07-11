<nav class="nav-menu bg-[#0396D5] md:justify-center flex py-0 md:py-6 text-white items-center fixed top-0 w-full left-0 right-0 z-40">
        <div class="w-5/6 gap-x-32 items-center hidden min-[1024px]:flex">
            <img 
                src="/eco-logo3.png" 
                alt="White Logo"
                class="w-[220px]"
                width="200"
                height="100"
            />
            <ul class="menu-list flex gap-x-12">
              <li class="menu-item">
                  <a href="/">Home</a>
              </li>
              <li class="menu-item">
                  <a href="/about-us">About Us</a>
              </li>
              <li class="menu-item with-dropdown">
                  <a href="/solutions">Solutions</a>
                  <div class="dropdown pt-6">
                      <ul class="submenu">
                        <li class="menu-item with-subdropdown block w-full">
                              <a href="/solutions/continuous-emission-monitoring-system" class=" block w-full px-6 py-3">Continuous Emission Monitoring System</a>
                              <div class="subdropdown">
                                  <ul class="subsubmenu">
                                      <li class="block w-full"><a href="/solutions/continuous-emission-monitoring-system" class="block w-full px-6 py-3">Dr. Fodisch</a></li>
                                      <li class="block w-full"><a href="/solutions/continuous-emission-monitoring-system#abb" class="block w-full px-6 py-3">ABB</a></li>
                                      <li class="block w-full"><a href="/solutions/continuous-emission-monitoring-system#envea" class="block w-full px-6 py-3">Envea</a></li>
                                      <li class="block w-full"><a href="/solutions/continuous-emission-monitoring-system#sick" class="block w-full px-6 py-3">SICK</a></li>
                                  </ul>
                              </div>
                          </li>
                          <li class="menu-item with-subdropdown block w-full">
                              <a href="/solutions/process-analyzer" class="block w-full px-6 py-3">Process Analzyer</a>
                              <div class="subdropdown">
                                <ul class="subsubmenu relative">
                                  <li class="block w-full"><a href="/solutions/process-analyzer" class="block w-full px-6 py-3">ECD</a></li>
                                  <li class="block w-full"><a href="/solutions/process-analyzer#phymetrix" class="block w-full px-6 py-3">PhyMetrix</a></li>
                                  <li class="block w-full"><a href="/solutions/process-analyzer#southland" class="block w-full px-6 py-3">Southland Sensing</a></li>
                                </ul>
                              </div>
                          </li>
                          
                          <li class="menu-item with-subdropdown block w-full">
                              <a href="/solutions/iot-system" class=" block w-full px-6 py-3">IOT System</a>
                          </li>
                          <li class="menu-item with-subdropdown block w-full">
                              <a href="/solutions/system-integration" class=" block w-full px-6 py-3">System Integration Work</a>
                          </li>
                      </ul>
                  </div>
              </li>
              <li class="menu-item">
              <a href="/#contact-us">Contact Us</a>
              </li>
          </ul>
        </div>
        <!-- Mobile Menu -->
        <div class="relative min-[1024px]:hidden block w-full">
          <div class="flex justify-between items-center w-full px-6 max-[767px]:py-4 mobile_menu">
            <img 
                  src="/eco-logo3.png" 
                  alt="White Logo"
                  class="block"
                  width="300"
                  height="100"
              />
            <div class="burger-icon z-[3] cursor-pointer" id="burger-icon">
              <div class="bar"></div>
              <div class="bar"></div>
              <div class="bar"></div>
            </div>
            <div class="menu" id="menu">
              <img 
                  src="/white_logo_text_mobile.png" 
                  alt="Logo"
                  class="block mt-4 ml-6"
                  width="200"
                  height="100"
              />
              <ul class="mt-6 min-[575px]:mt-12 ml-4">
                <li><a href="/">Home</a></li>
                <li><a href="/about-us">About Us</a></li>
                <li><a href="/solutions">Solutions</a></li>
                <li><a href="#" class="toggle-submenu flex justify-between items-center"><span>Continuous Emission Monitoring System</span><i class="fas fa-chevron-right transition"></i></a>
                  <div class="submenu">
                    <a href="/solutions/continuous-emission-monitoring-system" class="block w-fit px-6 py-3">Dr. Födisch</a>
                    <a href="/solutions/continuous-emission-monitoring-system#abb" class="block w-fit px-6 pb-3">ABB</a>
                    <a href="/solutions/continuous-emission-monitoring-system#envea" class="block w-fit px-6 pb-3">Envea</a>
                    <a href="/solutions/continuous-emission-monitoring-system#sick" class="block w-fit px-6 pb-3">SICK</a>
                  </div>
                </li>
                <li><a href="#" class="toggle-submenu flex justify-between items-center"><span>Process Analzyer</span><i class="fas fa-chevron-right transition"></i></a>
                <div class="submenu">
                  <a href="/solutions/process-analyzer" class="block w-fit px-6 py-3">ECD</a>
                  <a href="/solutions/process-analyzer#phymetrix" class="block w-fit px-6 pb-3">PhyMetrix</a>
                  <a href="/solutions/process-analyzer#southland" class="block w-fit px-6 pb-3">Southland Sensing</a>
                </div></li>
                
                <li><a href="/solutions/iot-system">IOT System</a></li>
                <li><a href="/solutions/system-integration" class="toggle-submenu flex justify-between items-center"><span>System Integration Work</span></a>
                  <!-- <div class="submenu">
                    <a href="/system-integration-work" class="block w-fit px-6 py-3">System Integration Work</a>
                  </div> -->
                </li>
                <li><a href="/#contact-us">Contact Us</a></li>
              </ul>
              <p class="ottom-0 left-0 right-0 text-black mx-auto px-4 text-center text-[11px] py-6">&copy; <span class="latestYear"></span> ECOSLINKSOLUTIONS. All rights reserved.</p>
            </div>
            <div class="overlay" id="overlay"></div>
          </div>
        </div>
    </nav>