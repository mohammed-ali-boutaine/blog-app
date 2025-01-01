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
      width: 800px;
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
          <!-- Single Post -->
          <!-- ------------------------------------------------------------------------------------- -->

          <?php  
          
          include "./article/show.php";
          ?>










        
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