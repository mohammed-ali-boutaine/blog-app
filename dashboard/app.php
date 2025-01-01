<?php

require "../db/conn.php";
require "../functions/helpers.php";
if (!check_user_authentication()) {
  header("Location: ../index.php");
  exit();
}
$user_id = sanitize_input($_COOKIE['user_id']);
$stmt = $conn->prepare("SELECT username,email,profile_picture FROM users WHERE id = ? ");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
// print_r($user);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com" defer></script>
  <style>
    #post>div {
      height: fit-content;
    }

    .post .comments-section {

      transition: 300ms max-width ease;
      display: none;
      padding: 0;
      max-width: 0;
      overflow: hidden;
    }

    .post.active .comments-section {
      display: block;

      max-width: 1000px;
      /* Adjust as needed to fit the content */
    }

    #post {
      width: fit-content;
      /* display: none; */

    }

    .comments-section::-webkit-scrollbar {
      width: 8px;
      /* Set the width of the scrollbar */
    }

    .comments-section::-webkit-scrollbar-track {
      background: transparent;
      /* Make the track transparent */
    }

    .comments-section::-webkit-scrollbar-thumb {
      background-color: rgba(0, 0, 0, 0.6);
      /* Black with transparency */
      border-radius: 10px;
      /* Make the scrollbar thumb rounded */
    }

    main {
      margin-top: 10px;
      /* border: 1px solid red; */
    }

    #left-aside {


      height: calc(100vh - 90px);
    }

    #posts::-webkit-scrollbar {
      display: none;
    }

    /* Ensure scrollability */
    #posts {
      -ms-overflow-style: none;
      /* For Internet Explorer */
      scrollbar-width: none;
      /* For Firefox */
    }

    #posts {
      box-sizing: border-box;
      overflow-y: scroll;
      /* border: solid red 1px; */
      height: calc(100vh - 90px);
    }
  </style>
  </style>
</head>



<body class="bg-zinc-900 text-white">
  <!-- Header -->
  <header
    class="w-full bg-gray-950 pt-2 px-6 ">
    <div class="max-w-screen-xl mx-auto px-5 flex justify-between items-center">
      <div class="text-2xl font-bold">B</div>

      <!-- Username and Dropdown -->
      <div class="flex items-center">
        <button
          id="toggleFormBtn"
          class="bg-gray-950 text-white px-4 py-2 rounded hover:bg-gray-500">
          Create Post
        </button>
        <div class="relative ">

          <button id="userMenuButton" class="flex items-center justify-center">
            <div
              class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center overflow-hidden">
              <!-- Dynamic Profile Picture -->
              <?php if (!empty($user['profile_picture'])): ?>
                <img
                  src="<?php echo htmlspecialchars($user['profile_picture']); ?>"
                  alt="User Profile"
                  class="w-full h-full object-cover" />
              <?php else: ?>
                <!-- Default Placeholder -->
                <span class="text-sm font-medium text-white">User</span>
              <?php endif; ?>
            </div>

          </button>
          <div class="flex justify-center itmes-center">

            <?php echo $user['username']; ?>
          </div>

          <!-- Dropdown -->
          <ul
            id="userMenu"
            class="absolute right-0 mt-2 bg-gray-700 rounded-md w-36 hidden shadow-lg text-center overflow-hidden">
            <li class="p-2 hover:bg-gray-600 hover:text-white cursor-pointer">Account</li>
            <li class="p-2 hover:bg-gray-600 hover:text-white cursor-pointer">Settings</li>
            <li class="p-2 hover:bg-gray-600 hover:text-white cursor-pointer">About</li>
            <li class="p-2 hover:bg-gray-600 hover:text-white cursor-pointer">Contact</li>
            <li class="p-2 hover:bg-red-600 hover:text-white cursor-pointer text-red-500">
              <a href="../view/user_logout.php" class="block w-full h-full">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </div>

  </header>

  <main class="max-w-screen-xl mx-auto px-5  ">
    <div class="flex flex-col md:flex-row rounded">
      <aside
        id="left-aside"
        class="w-full md:w-1/5 p-4 bg-gray-950 space-y-6 text-center rounded">
        <div class="bg-gray-600 p-4 rounded hover:bg-gray-500 cursor-pointer">
          Tags
        </div>
        <div class="bg-gray-600 p-4 rounded hover:bg-gray-500 cursor-pointer">
          Popular Posts
        </div>
        <div class="bg-gray-600 p-4 rounded hover:bg-gray-500 cursor-pointer">
          Announcements
        </div>
      </aside>
      <!-- Posts Section -->
      <section id="posts" class="w-full px-4 ">
        <!-- Post Navigation -->
        <div class="flex justify-center items-center space-x-4 mb-2">
          <button
            class="bg-gray-950 text-white px-4 py-2 rounded hover:bg-gray-500">
            Public Posts
          </button>
          <button
            class="bg-gray-950 text-white px-4 py-2 rounded hover:bg-gray-500">
            Your Posts
          </button>
        </div>

        <!-- Posts -->
        <div id="post" class="post flex box-border border-2 border-slate-800		mb-4  rounded-lg ">
          <!-- Single Post -->
          <!-- ------------------------------------------------------------------------------------- -->

          <div
            class="max-w-2xl shadow-md rounded-lg overflow-hidden  border-gray-700 bg-gray-950">
            <!-- Post Content -->
            <div class="p-6 relative">
              <!-- Three-dot Menu -->
              <div class="absolute top-4 right-4">
                <button
                  class="text-gray-300 hover:text-gray-100 focus:outline-none"
                  id="menu-button">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 6v.01M12 12v.01M12 18v.01" />
                  </svg>
                </button>
                <!-- Menu Popup -->
                <div
                  id="menu-popup"
                  class="hidden absolute right-0 mt-2 bg-gray-800 text-gray-300 rounded shadow-lg z-10">
                  <ul>
                    <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">
                      Edit
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">
                      Delete
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">
                      Signal
                    </li>
                  </ul>
                </div>
              </div>

              <!-- Author Info -->
              <div class="flex items-center space-x-4 mb-4">
                <img
                  class="w-12 h-12 rounded-full object-cover"
                  src="https://via.placeholder.com/150"
                  alt="Author Image" />
                <div>
                  <p class="text-white font-bold text-lg">John Doe</p>
                  <p class="text-gray-400 text-sm">Created at: Dec 18, 2024</p>
                </div>
              </div>

              <!-- Post Title -->
              <h2 class="text-2xl font-semibold text-gray-100 mb-2">
                The Art of Minimalism
              </h2>

              <!-- Post Content -->
              <p class="text-gray-400 text-sm" id="post-content">
                Minimalism is about removing the unnecessary to focus on what
                truly matters. Learn how to simplify your life and embrace the
                essentials...
                <span id="full-content" class="hidden">
                  Minimalism is not just about decluttering your home; it’s
                  about decluttering your mind and soul. It is a philosophy that
                  encourages intentional living and finding joy in simplicity.
                </span>
              </p>

              <!-- Read More Button -->
              <button
                id="read-more-btn"
                class="text-blue-400 text-sm font-medium hover:underline">
                Read more
              </button>
            </div>

            <!-- Post Image -->
            <!-- <img
              class="w-full h-64 object-cover"
              src="https://via.placeholder.com/800x400"
              alt="Post Image" /> -->

            <!-- Buttons: Like and Comment -->
            <div class="flex items-center justify-between p-4">
              <div class="flex space-x-4">
                <!-- Like Button -->
                <button
                  class="flex items-center space-x-1 text-gray-400 hover:text-red-500">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M14 9l-.882-3.528a1 1 0 00-.97-.772H9a1 1 0 00-.707.293l-3 3a1 1 0 00-.293.707v6a1 1 0 001 1h3v4a1 1 0 001 1h3a1 1 0 001-1v-4h3a1 1 0 001-1v-2.768a2 2 0 00-.586-1.414l-2-2A2 2 0 0014 9z" />
                  </svg>
                  <span class="text-sm">24</span>
                </button>

                <!-- Comment Button -->
                <button
                  class="comments-btn flex items-center space-x-1 text-gray-400 hover:text-blue-500">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M3 10v11a1 1 0 001 1h7a1 1 0 001-1v-5h5a1 1 0 001-1V3a1 1 0 00-1-1H4a1 1 0 00-1 1v7z" />
                  </svg>
                  <span class="text-sm">12</span>
                </button>
              </div>
            </div>
          </div>
          <!-- Comments Section -->
          <div

            class="  comments-section  rounded-lg p-6 bg-gray-900 text-gray-200  h-full max-h-[520px] overflow-y-scroll ">
            <!-- Add New Comment -->
            <div>
              <textarea
                class="w-full p-3 rounded-md bg-gray-800 text-gray-200 placeholder-gray-400"
                rows="3"
                placeholder="Add a comment..."></textarea>
              <button
                class="mt-2 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                Post Comment
              </button>
            </div>
            <h3 class="text-lg font-bold mb-4">Comments</h3>

            <div class="space-y-4">
              <!-- Comment 1 -->
              <div class="p-4 bg-gray-800 rounded-md">
                <p class="font-semibold">Jane Doe</p>
                <p class="text-sm text-gray-400">
                  This is a fantastic article on minimalism! Thank you for
                  sharing.
                </p>
              </div>
              <!-- Comment 2 -->
              <div class="p-4 bg-gray-800 rounded-md">
                <p class="font-semibold">John Smith</p>
                <p class="text-sm text-gray-400">
                  I’ve been looking to simplify my life, and this gave me great
                  insights.
                </p>
              </div>
              <!-- Comment 2 -->
              <div class="p-4 bg-gray-800 rounded-md">
                <p class="font-semibold">John Smith</p>
                <p class="text-sm text-gray-400">
                  I’ve been looking to simplify my life, and this gave me great
                  insights.
                </p>
              </div>
              <!-- Comment 2 -->
              <div class="p-4 bg-gray-800 rounded-md">
                <p class="font-semibold">John Smith</p>
                <p class="text-sm text-gray-400">
                  I’ve been looking to simplify my life, and this gave me great
                  insights.
                </p>
              </div>
              <!-- Comment 2 -->
              <div class="p-4 bg-gray-800 rounded-md">
                <p class="font-semibold">John Smith</p>
                <p class="text-sm text-gray-400">
                  I’ve been looking to simplify my life, and this gave me great
                  insights.
                </p>
              </div>
              <!-- Add more comments here -->
            </div>
          </div>

          <!-- ------------------------------------------------------------------------------------- -->
        </div>
        <div id="post" class="post flex box-border border-2 border-slate-800		mb-4  rounded-lg ">
          <!-- Single Post -->
          <!-- ------------------------------------------------------------------------------------- -->

          <div
            class="max-w-2xl shadow-md rounded-lg overflow-hidden  border-gray-700 bg-gray-950">
            <!-- Post Content -->
            <div class="p-6 relative">
              <!-- Three-dot Menu -->
              <div class="absolute top-4 right-4">
                <button
                  class="text-gray-300 hover:text-gray-100 focus:outline-none"
                  id="menu-button">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 6v.01M12 12v.01M12 18v.01" />
                  </svg>
                </button>
                <!-- Menu Popup -->
                <div
                  id="menu-popup"
                  class="hidden absolute right-0 mt-2 bg-gray-800 text-gray-300 rounded shadow-lg z-10">
                  <ul>
                    <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">
                      Edit
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">
                      Delete
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">
                      Signal
                    </li>
                  </ul>
                </div>
              </div>

              <!-- Author Info -->
              <div class="flex items-center space-x-4 mb-4">
                <img
                  class="w-12 h-12 rounded-full object-cover"
                  src="https://via.placeholder.com/150"
                  alt="Author Image" />
                <div>
                  <p class="text-white font-bold text-lg">John Doe</p>
                  <p class="text-gray-400 text-sm">Created at: Dec 18, 2024</p>
                </div>
              </div>

              <!-- Post Title -->
              <h2 class="text-2xl font-semibold text-gray-100 mb-2">
                The Art of Minimalism
              </h2>

              <!-- Post Content -->
              <p class="text-gray-400 text-sm" id="post-content">
                Minimalism is about removing the unnecessary to focus on what
                truly matters. Learn how to simplify your life and embrace the
                essentials...
                <span id="full-content" class="hidden">
                  Minimalism is not just about decluttering your home; it’s
                  about decluttering your mind and soul. It is a philosophy that
                  encourages intentional living and finding joy in simplicity.
                </span>
              </p>

              <!-- Read More Button -->
              <button
                id="read-more-btn"
                class="text-blue-400 text-sm font-medium hover:underline">
                Read more
              </button>
            </div>

            <!-- Post Image -->
            <img
              class="w-full h-64 object-cover"
              src="https://via.placeholder.com/800x400"
              alt="Post Image" />

            <!-- Buttons: Like and Comment -->
            <div class="flex items-center justify-between p-4">
              <div class="flex space-x-4">
                <!-- Like Button -->
                <button
                  class="flex items-center space-x-1 text-gray-400 hover:text-red-500">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M14 9l-.882-3.528a1 1 0 00-.97-.772H9a1 1 0 00-.707.293l-3 3a1 1 0 00-.293.707v6a1 1 0 001 1h3v4a1 1 0 001 1h3a1 1 0 001-1v-4h3a1 1 0 001-1v-2.768a2 2 0 00-.586-1.414l-2-2A2 2 0 0014 9z" />
                  </svg>
                  <span class="text-sm">24</span>
                </button>

                <!-- Comment Button -->
                <button
                  class="comments-btn flex items-center space-x-1 text-gray-400 hover:text-blue-500">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M3 10v11a1 1 0 001 1h7a1 1 0 001-1v-5h5a1 1 0 001-1V3a1 1 0 00-1-1H4a1 1 0 00-1 1v7z" />
                  </svg>
                  <span class="text-sm">12</span>
                </button>
              </div>
            </div>
          </div>
          <!-- Comments Section -->
          <div

            class="  comments-section  rounded-lg p-6 bg-gray-900 text-gray-200  h-full max-h-[520px] overflow-y-scroll ">
            <!-- Add New Comment -->
            <div>
              <textarea
                class="w-full p-3 rounded-md bg-gray-800 text-gray-200 placeholder-gray-400"
                rows="3"
                placeholder="Add a comment..."></textarea>
              <button
                class="mt-2 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                Post Comment
              </button>
            </div>
            <h3 class="text-lg font-bold mb-4">Comments</h3>

            <div class="space-y-4">
              <!-- Comment 1 -->
              <div class="p-4 bg-gray-800 rounded-md">
                <p class="font-semibold">Jane Doe</p>
                <p class="text-sm text-gray-400">
                  This is a fantastic article on minimalism! Thank you for
                  sharing.
                </p>
              </div>
              <!-- Comment 2 -->
              <div class="p-4 bg-gray-800 rounded-md">
                <p class="font-semibold">John Smith</p>
                <p class="text-sm text-gray-400">
                  I’ve been looking to simplify my life, and this gave me great
                  insights.
                </p>
              </div>
              <!-- Comment 2 -->
              <div class="p-4 bg-gray-800 rounded-md">
                <p class="font-semibold">John Smith</p>
                <p class="text-sm text-gray-400">
                  I’ve been looking to simplify my life, and this gave me great
                  insights.
                </p>
              </div>
              <!-- Comment 2 -->
              <div class="p-4 bg-gray-800 rounded-md">
                <p class="font-semibold">John Smith</p>
                <p class="text-sm text-gray-400">
                  I’ve been looking to simplify my life, and this gave me great
                  insights.
                </p>
              </div>
              <!-- Comment 2 -->
              <div class="p-4 bg-gray-800 rounded-md">
                <p class="font-semibold">John Smith</p>
                <p class="text-sm text-gray-400">
                  I’ve been looking to simplify my life, and this gave me great
                  insights.
                </p>
              </div>
              <!-- Add more comments here -->
            </div>
          </div>

          <!-- ------------------------------------------------------------------------------------- -->
        </div>










        
      </section>
    </div>
  </main>
  </div>

  <!-- create blog form  -->
  <!-- Form Container -->
  <div id="formContainer"
    class="absolute inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-75">
    <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md relative">
      <!-- Close Button -->
      <button id="closeFormBtn"
        class="absolute top-2 right-2 bg-red-500 text-white rounded p-2 flex justify-center items-center hover:bg-red-600 transition duration-200">
        close
      </button>

      <h1 class="text-2xl font-bold text-gray-100 mb-4">Create a Blog Post</h1>
      <form  method="POST"  action="./article/add.php"enctype="multipart/form-data" >
        <!-- Title -->
        <div class="mb-4">
          <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
          <input type="text" id="title" name="title"
            class="mt-1 block w-full rounded-md p-2 bg-gray-700 border-gray-600 text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="Enter the title" required>
        </div>

        <!-- Content -->
        <div class="mb-4">
          <label for="content" class="block text-sm font-medium text-gray-300">Content</label>
          <textarea id="content" name="content" rows="5"
            class="mt-1 block w-full  p-2  rounded-md bg-gray-700 border-gray-600 text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="Write your content here..." ></textarea>
        </div>

        <!-- Image -->
        <div class="mb-4">
          <label for="image" class="block text-sm font-medium text-gray-300">Upload Image</label>
          <input type="file" id="image" name="image" accept="image/*"
            class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Submit Button -->
        <button type="submit"
          class="w-full bg-blue-500 text-white font-medium py-2 rounded-md hover:bg-blue-600 transition duration-200">
          Post
        </button>
      </form>
    </div>
  </div>

  <!-- Script -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const readMoreBtn = document.getElementById("read-more-btn");
      const fullContent = document.getElementById("full-content");
      const menuButton = document.getElementById("menu-button");
      const menuPopup = document.getElementById("menu-popup");

      // Toggle "Read More"
      readMoreBtn.addEventListener("click", function() {
        if (fullContent.classList.contains("hidden")) {
          fullContent.classList.remove("hidden");
          readMoreBtn.textContent = "Read less";
        } else {
          fullContent.classList.add("hidden");
          readMoreBtn.textContent = "Read more";
        }
      });

      // Toggle Menu Popup
      menuButton.addEventListener("click", function() {
        menuPopup.classList.toggle("hidden");
      });

      // Close menu if clicked outside
      document.addEventListener("click", function(event) {
        if (!menuButton.contains(event.target) && !menuPopup.contains(event.target)) {
          menuPopup.classList.add("hidden");
        }
      });
    });



    // document.addEventListener("DOMContentLoaded", function() {
    //   const readMoreBtn = document.getElementById("read-more-btn");
    //   const fullContent = document.getElementById("full-content");

    //   readMoreBtn.addEventListener("click", function() {
    //     if (fullContent.classList.contains("hidden")) {
    //       fullContent.classList.remove("hidden");
    //       readMoreBtn.textContent = "Read less";
    //     } else {
    //       fullContent.classList.add("hidden");
    //       readMoreBtn.textContent = "Read more";
    //     }
    //   });
    // });

    const userMenuButton = document.getElementById("userMenuButton");

    // const postCard = document.getElementById("post"); 
    const comments = document.querySelectorAll(".comments-btn");

    // console.log(comments);

    for (let comment of comments) {
      console.log(comment);
      comment.addEventListener("click", (ev) => {

        comment.closest(".post").classList.toggle("active");
      });
    }


    const userMenu = document.getElementById("userMenu");
    const toggleFormBtn = document.getElementById('toggleFormBtn');
    const formContainer = document.getElementById('formContainer');
    const closeFormBtn = document.getElementById('closeFormBtn');

    toggleFormBtn.addEventListener('click', () => {
      formContainer.classList.remove('hidden');
    });

    closeFormBtn.addEventListener('click', () => {
      formContainer.classList.add('hidden');
    });

    // User dropdown toggle
    userMenuButton.addEventListener("click", () => {
      userMenu.classList.toggle("hidden");
    });

    // Close dropdown when clicking outside
    window.addEventListener("click", (e) => {
      if (
        !userMenuButton.contains(e.target) &&
        !userMenu.contains(e.target)
      ) {
        userMenu.classList.add("hidden");
      }
    });
  </script>



</body>

</html>