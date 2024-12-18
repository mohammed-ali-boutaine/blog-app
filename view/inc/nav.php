<div class="max-w-screen-xl mx-auto px-5">

<header class="flex flex-col lg:flex-row justify-between items-center my-5">
                    <div class="flex w-full lg:w-auto items-center justify-between"> <a href="/" class="text-lg"><span class="font-bold text-slate-800">Blog</span><span class="text-slate-500">ship</span> </a>
                         <div class="block lg:hidden"> <button id="astronav-menu" aria-label="Toggle Menu"> <svg fill="currentColor" class="w-4 h-4 text-gray-800" width="24" height="24" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                                        <title>Toggle Menu</title>
                                        <path class="astronav-close-icon astronav-toggle hidden" fill-rule="evenodd" clip-rule="evenodd" d="M18.278 16.864a1 1 0 01-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 01-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 011.414-1.414l4.829 4.828 4.828-4.828a1 1 0 111.414 1.414l-4.828 4.829 4.828 4.828z"></path>
                                        <path class="astronav-open-icon astronav-toggle" fill-rule="evenodd" d="M4 5h16a1 1 0 010 2H4a1 1 0 110-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2z"></path>
                                   </svg> </button> </div>
                    </div>
                    <nav class="astronav-items astronav-toggle hidden w-full lg:w-auto mt-2 lg:flex lg:mt-0">
                         <ul class="flex flex-col lg:flex-row lg:gap-3">
                              <li class="relative">
                            
                              </li>
                              <!-- <li> <a href="/" class="flex lg:px-3 py-2 items-center text-gray-600 hover:text-gray-900"> <span></span> </a> </li> -->
                              <li> <a href="./user_dashboard.php" class="flex lg:px-3 py-2 items-center text-gray-600 hover:text-gray-900"> <span> Articles</span> </a> </li>
                              <li> <a href="/about.php" class="flex lg:px-3 py-2 items-center text-gray-600 hover:text-gray-900"> <span> About</span> </a> </li>
                              <li> <a href="/contact.php" class="flex lg:px-3 py-2 items-center text-gray-600 hover:text-gray-900"> <span> Contact</span> </a> </li>
                         </ul>
                         <div class="lg:hidden flex items-center mt-3 gap-4"> <a href="#" class="rounded text-center transition focus-visible:ring-2 ring-offset-2 ring-gray-200 w-full px-4 py-2 bg-gray-100 hover:bg-gray-200   border-2 border-transparent">Log in </a> <a href="#" class="rounded text-center transition focus-visible:ring-2 ring-offset-2 ring-gray-200 w-full px-4 py-2 bg-black text-white hover:bg-gray-800  border-2 border-transparent">Sign up </a> </div>
                    </nav>
                    <script>
                         (function() {
                              const closeOnClick = false;

                              ["DOMContentLoaded", "astro:after-swap"].forEach((event) => {
                                   document.addEventListener(event, addListeners);
                              });

                              // Function to clone and replace elements
                              function cloneAndReplace(element) {
                                   const clone = element.cloneNode(true);
                                   element.parentNode.replaceChild(clone, element);
                              }

                              function addListeners() {
                                   // Clean up existing listeners
                                   const oldMenuButton = document.getElementById("astronav-menu");
                                   if (oldMenuButton) {
                                        cloneAndReplace(oldMenuButton);
                                   }

                                   const oldDropdownMenus = document.querySelectorAll(".astronav-dropdown");
                                   oldDropdownMenus.forEach((menu) => {
                                        cloneAndReplace(menu);
                                   });

                                   // Mobile nav toggle
                                   const menuButton = document.getElementById("astronav-menu");
                                   menuButton && menuButton.addEventListener("click", toggleMobileNav);

                                   // Dropdown menus
                                   const dropdownMenus = document.querySelectorAll(".astronav-dropdown");
                                   dropdownMenus.forEach((menu) => {
                                        const button = menu.querySelector("button");
                                        button &&
                                             button.addEventListener("click", (event) =>
                                                  toggleDropdownMenu(event, menu, dropdownMenus)
                                             );

                                        // Handle Submenu Dropdowns
                                        const dropDownSubmenus = menu.querySelectorAll(
                                             ".astronav-dropdown-submenu"
                                        );

                                        dropDownSubmenus.forEach((submenu) => {
                                             const submenuButton = submenu.querySelector("button");
                                             submenuButton &&
                                                  submenuButton.addEventListener("click", (event) => {
                                                       event.stopImmediatePropagation();
                                                       toggleSubmenuDropdown(event, submenu);
                                                  });
                                        });
                                   });

                                   // Clicking away from dropdown will remove the dropdown class
                                   document.addEventListener("click", closeAllDropdowns);

                                   if (closeOnClick) {
                                        handleCloseOnClick();
                                   }
                              }

                              function toggleMobileNav() {
                                   [...document.querySelectorAll(".astronav-toggle")].forEach((el) => {
                                        el.classList.toggle("hidden");
                                   });
                              }

                              function toggleDropdownMenu(event, menu, dropdownMenus) {
                                   toggleMenu(menu);

                                   // Close one dropdown when selecting another
                                   Array.from(dropdownMenus)
                                        .filter((el) => el !== menu && !menu.contains(el))
                                        .forEach(closeMenu);

                                   event.stopPropagation();
                              }

                              function toggleSubmenuDropdown(event, submenu) {
                                   event.stopPropagation();
                                   toggleMenu(submenu);

                                   // Close sibling submenus at the same nesting level
                                   const siblingSubmenus = submenu
                                        .closest(".astronav-dropdown")
                                        .querySelectorAll(".astronav-dropdown-submenu");
                                   Array.from(siblingSubmenus)
                                        .filter((el) => el !== submenu && !submenu.contains(el))
                                        .forEach(closeMenu);
                              }

                              function closeAllDropdowns(event) {
                                   const dropdownMenus = document.querySelectorAll(".dropdown-toggle");
                                   const dropdownParent = document.querySelectorAll(
                                        ".astronav-dropdown, .astronav-dropdown-submenu"
                                   );
                                   const isButtonInsideDropdown = [
                                        ...document.querySelectorAll(
                                             ".astronav-dropdown button, .astronav-dropdown-submenu button, #astronav-menu"
                                        ),
                                   ].some((button) => button.contains(event.target));
                                   if (!isButtonInsideDropdown) {
                                        dropdownMenus.forEach((d) => {
                                             // console.log("I ran", d);
                                             // if (!d.contains(event.target)) {
                                             d.classList.remove("open");
                                             d.removeAttribute("open");
                                             d.classList.add("hidden");
                                             // }
                                        });
                                        dropdownParent.forEach((d) => {
                                             d.classList.remove("open");
                                             d.removeAttribute("open");
                                             d.setAttribute("aria-expanded", "false");
                                        });
                                   }
                              }

                              function toggleMenu(menu) {
                                   menu.classList.toggle("open");
                                   const expanded = menu.getAttribute("aria-expanded") === "true";
                                   menu.setAttribute("aria-expanded", expanded ? "false" : "true");
                                   menu.hasAttribute("open") ?
                                        menu.removeAttribute("open") :
                                        menu.setAttribute("open", "");

                                   const dropdownToggle = menu.querySelector(".dropdown-toggle");
                                   const dropdownExpanded = dropdownToggle.getAttribute("aria-expanded");
                                   dropdownToggle.classList.toggle("hidden");
                                   dropdownToggle.setAttribute(
                                        "aria-expanded",
                                        dropdownExpanded === "true" ? "false" : "true"
                                   );
                              }

                              function closeMenu(menu) {
                                   // console.log("closing", menu);
                                   menu.classList.remove("open");
                                   menu.removeAttribute("open");
                                   menu.setAttribute("aria-expanded", "false");
                                   const dropdownToggles = menu.querySelectorAll(".dropdown-toggle");
                                   dropdownToggles.forEach((toggle) => {
                                        toggle.classList.add("hidden");
                                        toggle.setAttribute("aria-expanded", "false");
                                   });
                              }

                              function handleCloseOnClick() {
                                   const navMenuItems = document.querySelector(".astronav-items");
                                   const navToggle = document.getElementById("astronav-menu");
                                   const navLink = navMenuItems && navMenuItems.querySelectorAll("a");

                                   const MenuIcons = navToggle.querySelectorAll(".astronav-toggle");

                                   navLink &&
                                        navLink.forEach((item) => {
                                             item.addEventListener("click", () => {
                                                  navMenuItems?.classList.add("hidden");
                                                  MenuIcons.forEach((el) => {
                                                       el.classList.toggle("hidden");
                                                  });
                                             });
                                        });
                              }
                         })();
                    </script>
                    <div>
                         <div class="hidden lg:flex items-center gap-4"> 
                              <a href="./user_login.php">Log in</a>
                              <a href="./user_register.php" class="rounded text-center transition focus-visible:ring-2 ring-offset-2 ring-gray-200 px-4 py-2 bg-black text-white hover:bg-gray-800  border-2 border-transparent">Sign up </a>
                          </div>
                    </div>
               </header>

</div>