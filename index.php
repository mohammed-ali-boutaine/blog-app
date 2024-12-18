<?php
require './db/conn.php';
require './functions/helpers.php';  // Include your helper functions

// Check if the user is authenticated

if(check_user_authentication()){
     redirect("./dashboard/app.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

     <body>
          <div class="max-w-screen-xl mx-auto px-5">




          <!-- nav bar  -->
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
                              <li> <a href="./view/user_dashboard.php" class="flex lg:px-3 py-2 items-center text-gray-600 hover:text-gray-900"> <span> Articles</span> </a> </li>
                              <li> <a href="/view/about.php" class="flex lg:px-3 py-2 items-center text-gray-600 hover:text-gray-900"> <span> About</span> </a> </li>
                              <li> <a href="/view/contact.php" class="flex lg:px-3 py-2 items-center text-gray-600 hover:text-gray-900"> <span> Contact</span> </a> </li>
                          
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
                              <a href="./view/user_login.php">Log in</a>
                              <a href="./view/user_register.php" class="rounded text-center transition focus-visible:ring-2 ring-offset-2 ring-gray-200 px-4 py-2 bg-black text-white hover:bg-gray-800  border-2 border-transparent">Sign up </a>
                          </div>
                    </div>
               </header>




          </div>
          <div class="max-w-screen-xl mx-auto px-5">
               <main class="grid lg:grid-cols-2 place-items-center pt-16 pb-8 md:pt-12 md:pb-24">
                    <div class="py-6 md:order-1 hidden md:block">
                         <picture>
                              <source srcset="/public/images/hero.webp 200w, /public/images/hero.webp 400w, /public/images/hero.webp  600w" type="image/webp" sizes="(max-width: 800px) 100vw, 620px"> <img src="./public/images/hero.webp" srcset="/_astro/hero.DlKDY3ml_Zb8dUS.png 200w, /_astro/hero.DlKDY3ml_1U3Pls.png 400w, /public/images/hero.webp  600w" alt="Astronaut in the air" sizes="(max-width: 800px) 100vw, 620px" loading="eager" width="520" height="424" decoding="async">
                         </picture>
                    </div>
                    <div>
                         <h1 class="text-5xl lg:text-6xl xl:text-7xl font-bold lg:tracking-tight xl:tracking-tighter">
            Build and Manage Your Blog Effortlessly
                         </h1>
                         <p class="text-lg mt-4 text-slate-600 max-w-xl">
            BlogMaster is a complete blog web app starter template, powered by Astro and TailwindCSS.<wbr> 
            Perfect for writers, creators, and developers who want a clean, fast, and customizable blogging platform.
        </p>
          <div class="mt-6 flex flex-col sm:flex-row gap-3">
               <a href="./view/user_register.php" target="_blank" rel="noopener" class="rounded text-center transition focus-visible:ring-2 ring-offset-2 ring-gray-200 px-5 py-2.5 bg-black text-white hover:bg-gray-800  border-2 border-transparent flex gap-1 items-center justify-center"> 
                                Create Account Now
               </a> <a href="./view/user_login.php" rel="noopener" target="_blank" class="rounded text-center transition focus-visible:ring-2 ring-offset-2 ring-gray-200 px-5 py-2.5 bg-white border-2 border-black hover:bg-gray-100 text-black  flex gap-1 items-center justify-center">
                      Login
                </a> 
          </div>
     </div>




               </main>
               <div class="mt-16 md:mt-0">
                    <h2 class="text-4xl lg:text-5xl font-bold lg:tracking-tight">
                         Everything you need to start a website
                    </h2>
                    <p class="text-lg mt-4 text-slate-600">
                         Astro comes batteries included. It takes the best parts of state-of-the-art
                         tools and adds its own innovations.
                    </p>
               </div>



               <div class="grid sm:grid-cols-2 md:grid-cols-3 mt-16 gap-16">
                    <div class="flex gap-4 items-start">
                         <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0"> <svg width="1em" height="1em" viewBox="0 0 24 24" class="text-white" data-icon="bx:bxs-briefcase">
                                   <symbol id="ai:bx:bxs-briefcase">
                                        <path d="M20 6h-3V4c0-1.103-.897-2-2-2H9c-1.103 0-2 .897-2 2v2H4c-1.103 0-2 .897-2 2v3h20V8c0-1.103-.897-2-2-2zM9 4h6v2H9V4zm5 10h-4v-2H2v7c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2v-7h-8v2z" fill="currentColor"></path>
                                   </symbol>
                                   <use xlink:href="#ai:bx:bxs-briefcase"></use>
                              </svg> </div>
                         <div>
                              <h3 class="font-semibold text-lg">Bring Your Own Framework</h3>
                              <p class="text-slate-500 mt-2 leading-relaxed">Build your site using React, Svelte, Vue, Preact, web components, or just plain ol' HTML + JavaScript.</p>
                         </div>
                    </div>
                    <div class="flex gap-4 items-start">
                         <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0"> <svg width="1em" height="1em" viewBox="0 0 24 24" class="text-white" data-icon="bx:bxs-window-alt">
                                   <symbol id="ai:bx:bxs-window-alt">
                                        <path d="M20 3H4c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zm-3 3h2v2h-2V6zm-3 0h2v2h-2V6zM4 19v-9h16.001l.001 9H4z" fill="currentColor"></path>
                                   </symbol>
                                   <use xlink:href="#ai:bx:bxs-window-alt"></use>
                              </svg> </div>
                         <div>
                              <h3 class="font-semibold text-lg">100% Static HTML, No JS</h3>
                              <p class="text-slate-500 mt-2 leading-relaxed">Astro renders your entire page to static HTML, removing all JavaScript from your final build by default.</p>
                         </div>
                    </div>
                    <div class="flex gap-4 items-start">
                         <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0"> <svg width="1em" height="1em" viewBox="0 0 24 24" class="text-white" data-icon="bx:bxs-data">
                                   <symbol id="ai:bx:bxs-data">
                                        <path d="M20 6c0-2.168-3.663-4-8-4S4 3.832 4 6v2c0 2.168 3.663 4 8 4s8-1.832 8-4V6zm-8 13c-4.337 0-8-1.832-8-4v3c0 2.168 3.663 4 8 4s8-1.832 8-4v-3c0 2.168-3.663 4-8 4z" fill="currentColor"></path>
                                        <path d="M20 10c0 2.168-3.663 4-8 4s-8-1.832-8-4v3c0 2.168 3.663 4 8 4s8-1.832 8-4v-3z" fill="currentColor"></path>
                                   </symbol>
                                   <use xlink:href="#ai:bx:bxs-data"></use>
                              </svg> </div>
                         <div>
                              <h3 class="font-semibold text-lg">On-Demand Components</h3>
                              <p class="text-slate-500 mt-2 leading-relaxed">Need some JS? Astro can automatically hydrate interactive components when they become visible on the page. </p>
                         </div>
                    </div>
                    <div class="flex gap-4 items-start">
                         <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0"> <svg width="1em" height="1em" viewBox="0 0 24 24" class="text-white" data-icon="bx:bxs-bot">
                                   <symbol id="ai:bx:bxs-bot">
                                        <path d="M21 10.975V8a2 2 0 0 0-2-2h-6V4.688c.305-.274.5-.668.5-1.11a1.5 1.5 0 0 0-3 0c0 .442.195.836.5 1.11V6H5a2 2 0 0 0-2 2v2.998l-.072.005A.999.999 0 0 0 2 12v2a1 1 0 0 0 1 1v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5a1 1 0 0 0 1-1v-1.938a1.004 1.004 0 0 0-.072-.455c-.202-.488-.635-.605-.928-.632zM7 12c0-1.104.672-2 1.5-2s1.5.896 1.5 2s-.672 2-1.5 2S7 13.104 7 12zm8.998 6c-1.001-.003-7.997 0-7.998 0v-2s7.001-.002 8.002 0l-.004 2zm-.498-4c-.828 0-1.5-.896-1.5-2s.672-2 1.5-2s1.5.896 1.5 2s-.672 2-1.5 2z" fill="currentColor"></path>
                                   </symbol>
                                   <use xlink:href="#ai:bx:bxs-bot"></use>
                              </svg> </div>
                         <div>
                              <h3 class="font-semibold text-lg">Broad Integration</h3>
                              <p class="text-slate-500 mt-2 leading-relaxed">Astro supports TypeScript, Scoped CSS, CSS Modules, Sass, Tailwind, Markdown, MDX, and any other npm packages.</p>
                         </div>
                    </div>
                    <div class="flex gap-4 items-start">
                         <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0"> <svg width="1em" height="1em" viewBox="0 0 24 24" class="text-white" data-icon="bx:bxs-file-find">
                                   <symbol id="ai:bx:bxs-file-find">
                                        <path d="M6 22h12c.178 0 .348-.03.512-.074l-3.759-3.759A4.966 4.966 0 0 1 12 19c-2.757 0-5-2.243-5-5s2.243-5 5-5s5 2.243 5 5a4.964 4.964 0 0 1-.833 2.753l3.759 3.759c.044-.164.074-.334.074-.512V8l-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2z" fill="currentColor"></path>
                                        <circle cx="12" cy="14" r="3" fill="currentColor"></circle>
                                   </symbol>
                                   <use xlink:href="#ai:bx:bxs-file-find"></use>
                              </svg> </div>
                         <div>
                              <h3 class="font-semibold text-lg">SEO Enabled</h3>
                              <p class="text-slate-500 mt-2 leading-relaxed">Automatic sitemaps, RSS feeds, pagination and collections take the pain out of SEO and syndication. It just works!</p>
                         </div>
                    </div>
                    <div class="flex gap-4 items-start">
                         <div class="mt-1 bg-black rounded-full  p-2 w-8 h-8 shrink-0"> <svg width="1em" height="1em" viewBox="0 0 24 24" class="text-white" data-icon="bx:bxs-user">
                                   <symbol id="ai:bx:bxs-user">
                                        <path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2S7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z" fill="currentColor"></path>
                                   </symbol>
                                   <use xlink:href="#ai:bx:bxs-user"></use>
                              </svg> </div>
                         <div>
                              <h3 class="font-semibold text-lg">Community</h3>
                              <p class="text-slate-500 mt-2 leading-relaxed">Astro is an open source project powered by hundreds of contributors making thousands of individual contributions.</p>
                         </div>
                    </div>
               </div>




 </div>
     <div class="h-screen w-full overflow-hidden flex flex-nowrap text-center mt-16" id="slider">
          <div class="bg-blue-600 text-white space-y-4 flex-none w-full flex flex-col items-center justify-center">
               <h2 class="text-4xl max-w-md">Your Big Ideia</h2>
               <p class="max-w-md">It's fast, flexible, and reliable — with zero-runtime.</p>
          </div>
          <div class="bg-pink-400 text-white space-y-4 flex-none w-full flex flex-col items-center justify-center">
               <h2 class="text-4xl max-w-md">Tailwind CSS works by scanning all of your HTML</h2>
               <p class="max-w-md">It's fast, flexible, and reliable — with zero-runtime.</p>
          </div>
          <div class="bg-teal-500 text-white space-y-4 flex-none w-full flex flex-col items-center justify-center">
               <h2 class="text-4xl max-w-md">React, Vue, and HTML</h2>
               <p class="max-w-md">Accessible, interactive examples for React and Vue powered by Headless UI, plus vanilla HTML if you’d rather write any necessary JS yourself.</p>
          </div>
     </div>

<div>


























               <div class="bg-black p-8 md:px-20 md:py-20 mt-20 mx-auto max-w-5xl rounded-lg flex flex-col items-center text-center">
                    <h2 class="text-white text-4xl md:text-6xl tracking-tight">
                         Share Your Stories
                    </h2>
                    <p class="text-slate-400 mt-4 text-lg md:text-xl">
                         Pull content from anywhere and serve it fast with Astro's next-gen island
                         architecture.
                    </p>
                    <div class="flex mt-5"> <a href="#" class="rounded text-center transition focus-visible:ring-2 ring-offset-2 ring-gray-200 px-5 py-2.5 bg-white text-black   border-2 border-transparent">Get Started </a> </div>
               </div>
          </div>
          <footer class="my-20">
               <p class="text-center text-sm text-slate-500">
                    Copyright © 2024 Astroship. All rights reserved.
               </p> <!--
    Can we ask you a favor 🙏
    Please keep this backlink on your website if possible.
    or Purchase a commercial license from https://web3templates.com
  -->
               <p class="text-center text-xs text-slate-500 mt-1">
                    Made by <a href="https://web3templates.com" target="_blank" rel="noopener" class="hover:underline">
                         Web3Templates
                    </a> </p>
          </footer>
          <dv id="extension-dpfof"></dv>
          <div id="kins-kins-popup" style="color-scheme: initial; forced-color-adjust: initial; mask: initial; math-depth: initial; position: initial; position-anchor: initial; text-size-adjust: initial; appearance: initial; color: initial; direction: ltr; font-family: Rubik, sans-serif; font-feature-settings: initial; font-kerning: initial; font-optical-sizing: initial; font-palette: initial; font-size: medium; font-size-adjust: initial; font-stretch: initial; font-style: initial; font-synthesis: initial; font-variant: initial; font-variation-settings: initial; font-weight: initial; position-area: initial; text-orientation: initial; text-rendering: initial; text-spacing-trim: initial; -webkit-font-smoothing: initial; -webkit-locale: initial; -webkit-text-orientation: initial; -webkit-writing-mode: initial; writing-mode: initial; zoom: initial; accent-color: initial; place-content: initial; place-items: initial; place-self: initial; alignment-baseline: initial; anchor-name: initial; anchor-scope: initial; animation-composition: initial; animation: initial; app-region: initial; aspect-ratio: initial; backdrop-filter: initial; backface-visibility: initial; background: none; background-blend-mode: initial; baseline-shift: initial; baseline-source: initial; block-size: initial; border-block: initial; border: none; border-radius: initial; border-collapse: initial; border-end-end-radius: initial; border-end-start-radius: initial; border-inline: initial; border-start-end-radius: initial; border-start-start-radius: initial; inset: initial; box-decoration-break: initial; box-shadow: initial; box-sizing: border-box; break-after: initial; break-before: initial; break-inside: initial; buffered-rendering: initial; caption-side: initial; caret-color: initial; clear: initial; clip: initial; clip-path: initial; clip-rule: initial; color-interpolation: initial; color-interpolation-filters: initial; color-rendering: initial; columns: initial; column-fill: initial; gap: initial; column-rule: initial; column-span: initial; contain: initial; contain-intrinsic-block-size: initial; contain-intrinsic-size: initial; contain-intrinsic-inline-size: initial; container: initial; content: initial; content-visibility: initial; counter-increment: initial; counter-reset: initial; counter-set: initial; cursor: initial; cx: initial; cy: initial; d: initial; display: block; dominant-baseline: initial; empty-cells: initial; field-sizing: initial; fill: initial; fill-opacity: initial; fill-rule: initial; filter: initial; flex: initial; flex-flow: initial; float: initial; flood-color: initial; flood-opacity: initial; grid: initial; grid-area: initial; height: auto; hyphenate-character: initial; hyphenate-limit-chars: initial; hyphens: initial; image-orientation: initial; image-rendering: initial; initial-letter: initial; inline-size: initial; inset-block: initial; inset-inline: initial; interpolate-size: initial; isolation: initial; letter-spacing: initial; lighting-color: initial; line-break: initial; line-height: normal; list-style: initial; margin-block: initial; margin: 0px; margin-inline: initial; marker: initial; mask-type: initial; math-shift: initial; math-style: initial; max-block-size: initial; max-height: initial; max-inline-size: initial; max-width: initial; min-block-size: initial; min-height: initial; min-inline-size: initial; min-width: initial; mix-blend-mode: initial; object-fit: initial; object-position: initial; object-view-box: initial; offset: initial; opacity: initial; order: initial; orphans: initial; outline: initial; outline-offset: initial; overflow-anchor: initial; overflow-clip-margin: initial; overflow-wrap: initial; overflow: initial; overlay: initial; overscroll-behavior-block: none; overscroll-behavior-inline: none; overscroll-behavior: none; padding-block: initial; padding: 0px; padding-inline: initial; page: initial; page-orientation: initial; paint-order: initial; perspective: initial; perspective-origin: initial; pointer-events: initial; position-try: initial; position-visibility: initial; quotes: initial; r: initial; resize: initial; rotate: initial; ruby-align: initial; ruby-position: initial; rx: initial; ry: initial; scale: initial; scroll-behavior: initial; scroll-margin-block: initial; scroll-margin: initial; scroll-margin-inline: initial; scroll-padding-block: initial; scroll-padding: initial; scroll-padding-inline: initial; scroll-snap-align: initial; scroll-snap-stop: initial; scroll-snap-type: initial; scroll-timeline: initial; scrollbar-color: initial; scrollbar-gutter: initial; scrollbar-width: initial; shape-image-threshold: initial; shape-margin: initial; shape-outside: initial; shape-rendering: initial; size: initial; speak: initial; stop-color: initial; stop-opacity: initial; stroke: initial; stroke-dasharray: initial; stroke-dashoffset: initial; stroke-linecap: initial; stroke-linejoin: initial; stroke-miterlimit: initial; stroke-opacity: initial; stroke-width: initial; tab-size: initial; table-layout: initial; text-align: left; text-align-last: initial; text-anchor: initial; text-combine-upright: initial; text-decoration: none; text-decoration-skip-ink: initial; text-emphasis: initial; text-emphasis-position: initial; text-indent: initial; text-overflow: initial; text-shadow: initial; text-transform: initial; text-underline-offset: initial; text-underline-position: initial; text-wrap: wrap; timeline-scope: initial; touch-action: initial; transform: initial; transform-box: initial; transform-origin: initial; transform-style: initial; transition: initial; translate: initial; user-select: initial; vector-effect: initial; vertical-align: initial; view-timeline: initial; view-transition-class: initial; view-transition-name: initial; visibility: initial; border-spacing: initial; -webkit-box-align: initial; -webkit-box-decoration-break: initial; -webkit-box-direction: initial; -webkit-box-flex: initial; -webkit-box-ordinal-group: initial; -webkit-box-orient: initial; -webkit-box-pack: initial; -webkit-box-reflect: initial; -webkit-line-break: initial; -webkit-line-clamp: initial; -webkit-mask-box-image: initial; -webkit-print-color-adjust: initial; -webkit-rtl-ordering: initial; -webkit-ruby-position: initial; -webkit-tap-highlight-color: initial; -webkit-text-combine: initial; -webkit-text-decorations-in-effect: initial; -webkit-text-fill-color: initial; -webkit-text-security: initial; -webkit-text-stroke: initial; -webkit-user-drag: initial; white-space-collapse: collapse; widows: initial; width: auto; will-change: initial; word-break: initial; word-spacing: initial; x: initial; y: initial; z-index: initial;">
               <div id="kins_root" style="color-scheme: initial; forced-color-adjust: initial; mask: initial; math-depth: initial; position: initial; position-anchor: initial; text-size-adjust: initial; appearance: initial; color: initial; direction: ltr; font-family: Rubik, sans-serif; font-feature-settings: initial; font-kerning: initial; font-optical-sizing: initial; font-palette: initial; font-size: medium; font-size-adjust: initial; font-stretch: initial; font-style: initial; font-synthesis: initial; font-variant: initial; font-variation-settings: initial; font-weight: initial; position-area: initial; text-orientation: initial; text-rendering: initial; text-spacing-trim: initial; -webkit-font-smoothing: initial; -webkit-locale: initial; -webkit-text-orientation: initial; -webkit-writing-mode: initial; writing-mode: initial; zoom: initial; accent-color: initial; place-content: initial; place-items: initial; place-self: initial; alignment-baseline: initial; anchor-name: initial; anchor-scope: initial; animation-composition: initial; animation: initial; app-region: initial; aspect-ratio: initial; backdrop-filter: initial; backface-visibility: initial; background: none; background-blend-mode: initial; baseline-shift: initial; baseline-source: initial; block-size: initial; border-block: initial; border: none; border-radius: initial; border-collapse: initial; border-end-end-radius: initial; border-end-start-radius: initial; border-inline: initial; border-start-end-radius: initial; border-start-start-radius: initial; inset: initial; box-decoration-break: initial; box-shadow: initial; box-sizing: border-box; break-after: initial; break-before: initial; break-inside: initial; buffered-rendering: initial; caption-side: initial; caret-color: initial; clear: initial; clip: initial; clip-path: initial; clip-rule: initial; color-interpolation: initial; color-interpolation-filters: initial; color-rendering: initial; columns: initial; column-fill: initial; gap: initial; column-rule: initial; column-span: initial; contain: initial; contain-intrinsic-block-size: initial; contain-intrinsic-size: initial; contain-intrinsic-inline-size: initial; container: initial; content: initial; content-visibility: initial; counter-increment: initial; counter-reset: initial; counter-set: initial; cursor: initial; cx: initial; cy: initial; d: initial; display: block; dominant-baseline: initial; empty-cells: initial; field-sizing: initial; fill: initial; fill-opacity: initial; fill-rule: initial; filter: initial; flex: initial; flex-flow: initial; float: initial; flood-color: initial; flood-opacity: initial; grid: initial; grid-area: initial; height: auto; hyphenate-character: initial; hyphenate-limit-chars: initial; hyphens: initial; image-orientation: initial; image-rendering: initial; initial-letter: initial; inline-size: initial; inset-block: initial; inset-inline: initial; interpolate-size: initial; isolation: initial; letter-spacing: initial; lighting-color: initial; line-break: initial; line-height: normal; list-style: initial; margin-block: initial; margin: 0px; margin-inline: initial; marker: initial; mask-type: initial; math-shift: initial; math-style: initial; max-block-size: initial; max-height: initial; max-inline-size: initial; max-width: initial; min-block-size: initial; min-height: initial; min-inline-size: initial; min-width: initial; mix-blend-mode: initial; object-fit: initial; object-position: initial; object-view-box: initial; offset: initial; opacity: initial; order: initial; orphans: initial; outline: initial; outline-offset: initial; overflow-anchor: initial; overflow-clip-margin: initial; overflow-wrap: initial; overflow: initial; overlay: initial; overscroll-behavior-block: none; overscroll-behavior-inline: none; overscroll-behavior: none; padding-block: initial; padding: 0px; padding-inline: initial; page: initial; page-orientation: initial; paint-order: initial; perspective: initial; perspective-origin: initial; pointer-events: initial; position-try: initial; position-visibility: initial; quotes: initial; r: initial; resize: initial; rotate: initial; ruby-align: initial; ruby-position: initial; rx: initial; ry: initial; scale: initial; scroll-behavior: initial; scroll-margin-block: initial; scroll-margin: initial; scroll-margin-inline: initial; scroll-padding-block: initial; scroll-padding: initial; scroll-padding-inline: initial; scroll-snap-align: initial; scroll-snap-stop: initial; scroll-snap-type: initial; scroll-timeline: initial; scrollbar-color: initial; scrollbar-gutter: initial; scrollbar-width: initial; shape-image-threshold: initial; shape-margin: initial; shape-outside: initial; shape-rendering: initial; size: initial; speak: initial; stop-color: initial; stop-opacity: initial; stroke: initial; stroke-dasharray: initial; stroke-dashoffset: initial; stroke-linecap: initial; stroke-linejoin: initial; stroke-miterlimit: initial; stroke-opacity: initial; stroke-width: initial; tab-size: initial; table-layout: initial; text-align: left; text-align-last: initial; text-anchor: initial; text-combine-upright: initial; text-decoration: none; text-decoration-skip-ink: initial; text-emphasis: initial; text-emphasis-position: initial; text-indent: initial; text-overflow: initial; text-shadow: initial; text-transform: initial; text-underline-offset: initial; text-underline-position: initial; text-wrap: wrap; timeline-scope: initial; touch-action: initial; transform: initial; transform-box: initial; transform-origin: initial; transform-style: initial; transition: initial; translate: initial; user-select: initial; vector-effect: initial; vertical-align: initial; view-timeline: initial; view-transition-class: initial; view-transition-name: initial; visibility: initial; border-spacing: initial; -webkit-box-align: initial; -webkit-box-decoration-break: initial; -webkit-box-direction: initial; -webkit-box-flex: initial; -webkit-box-ordinal-group: initial; -webkit-box-orient: initial; -webkit-box-pack: initial; -webkit-box-reflect: initial; -webkit-line-break: initial; -webkit-line-clamp: initial; -webkit-mask-box-image: initial; -webkit-print-color-adjust: initial; -webkit-rtl-ordering: initial; -webkit-ruby-position: initial; -webkit-tap-highlight-color: initial; -webkit-text-combine: initial; -webkit-text-decorations-in-effect: initial; -webkit-text-fill-color: initial; -webkit-text-security: initial; -webkit-text-stroke: initial; -webkit-user-drag: initial; white-space-collapse: collapse; widows: initial; width: auto; will-change: initial; word-break: initial; word-spacing: initial; x: initial; y: initial; z-index: initial;"></div>
          </div>
          <script src="chrome-extension://gppongmhjkpfnbhagpmjfkannfbllamg/js/js.js"></script>
     </body>
     <!-- component -->

     <script>
          document.addEventListener('DOMContentLoaded', () => {
               const slider = document.querySelector('#slider');
               setTimeout(function moveSlide() {
                    const max = slider.scrollWidth - slider.clientWidth;
                    const left = slider.clientWidth;

                    if (max === slider.scrollLeft) {
                         slider.scrollTo({
                              left: 0,
                              behavior: 'smooth'
                         })
                    } else {
                         slider.scrollBy({
                              left,
                              behavior: 'smooth'
                         })
                    }

                    setTimeout(moveSlide, 2000)
               }, 2000)

          })
     </script>
</body>

</html>