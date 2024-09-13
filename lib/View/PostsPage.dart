import 'package:carexchange/Components/Categories.dart';
import 'package:carexchange/Components/PostsPageBar.dart';
import 'package:carexchange/Components/SearchBar.dart';
import 'package:carexchange/Controller/LikeController.dart';
import 'package:carexchange/Controller/PostController.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/View/PostDetails.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Postspage extends StatefulWidget {
  const Postspage({super.key});

  @override
  State<Postspage> createState() => _PostspageState();
}

class _PostspageState extends State<Postspage> {
  final PostController controller = Get.put(PostController());
  final LikeController likecontroller = Get.put(LikeController());

  Future<bool> _isLoggedIn() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('token') != null;
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xFFF5F7FA),
      appBar: AppBar(
        automaticallyImplyLeading: true,
        title: const PostsPageBar(),
        elevation: 0,
        backgroundColor: Colors.transparent,
      ),
      drawer: Drawer(
        backgroundColor: const Color.fromARGB(255, 4, 59, 154),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.end,
          children: [
            const SizedBox(height: 10),
            const Text(
              "Welcome, User!",
              style: TextStyle(
                  color: Colors.white,
                  fontSize: 20,
                  fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 20),
            FutureBuilder<bool>(
              future: _isLoggedIn(),
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return const CircularProgressIndicator(); // Show loading indicator
                }
                final isLoggedIn = snapshot.data ?? false;

                return Column(
                  children: [
                    ElevatedButton(
                      onPressed: isLoggedIn
                          ? () => Get.offNamed(AppRoute.newpost)
                          : null,
                      child: const Text("New post"),
                    ),
                    const SizedBox(height: 20),
                    ElevatedButton(
                      onPressed: isLoggedIn
                          ? () => Get.offNamed(AppRoute.MyLikes)
                          : null,
                      child: const Text("Show my favorites"),
                    ),
                    const SizedBox(height: 20),
                    ElevatedButton(
                      onPressed: isLoggedIn
                          ? () => Get.offNamed(AppRoute.MyPosts)
                          : null,
                      child: const Text("Show my posts"),
                    ),
                    const SizedBox(height: 400),
                    ElevatedButton(
                      onPressed: () {
                        if (isLoggedIn) {
                          controller.logOut();
                        } else {
                          Get.offNamed(AppRoute.login);
                        }
                      },
                      child: Text(isLoggedIn ? "Logout" : "Login"),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: isLoggedIn ? Colors.red : Colors.black,
                      ),
                    ),
                    const SizedBox(height: 70),
                  ],
                );
              },
            ),
          ],
        ),
      ),
      body: SafeArea(
        child: Padding(
          padding: EdgeInsets.only(
            left: 10,
            right: 10,
          ),
          child: SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const SizedBox(height: 20),
                const Searchbar(),
                const SizedBox(height: 20),
                Stack(
                  children: [
                    SizedBox(
                      height: 200,
                      width: double.infinity,
                      child: PageView.builder(
                        itemCount: 4,
                        itemBuilder: (context, index) {
                          return Container(
                            height: 200,
                            width: double.infinity,
                            decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(20),
                              image: const DecorationImage(
                                fit: BoxFit.fill,
                                image: AssetImage('assets/images/Header.jpg'),
                              ),
                            ),
                          );
                        },
                      ),
                    )
                  ],
                ),
                const SizedBox(height: 10),
                const Text(
                  "All Categories",
                  style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
                ),
                const SizedBox(height: 10),
                const Categories(),
                const SizedBox(height: 10),
                const Text(
                  "Items",
                  style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
                ),
                ElevatedButton(
                  onPressed: () {
                    controller.getPosts();
                  },
                  style: ElevatedButton.styleFrom(
                    foregroundColor: Colors.white,
                    backgroundColor: const Color.fromARGB(255, 4, 59, 154),
                    shadowColor: Colors.black,
                    elevation: 10,
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(30),
                    ),
                    padding: const EdgeInsets.symmetric(
                      horizontal: 15,
                      vertical: 10,
                    ),
                    textStyle: const TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  child: const Text('All'),
                ),
                const SizedBox(height: 10),
                Obx(() {
                  var filteredPosts = controller.filteredPosts;
                  var postsToDisplay =
                      filteredPosts.isEmpty ? controller.posts : filteredPosts;

                  if (postsToDisplay.isEmpty) {
                    return const Center(child: Text("No posts available"));
                  }

                  return ListView.separated(
                    padding: const EdgeInsets.all(20),
                    shrinkWrap: true,
                    physics:
                        const NeverScrollableScrollPhysics(), // Disable scrolling within the ListView
                    itemBuilder: (context, index) {
                      var post = postsToDisplay[index];
                      bool isFavorite = likecontroller.isFavorite(post.id);

                      return InkWell(
                        onTap: () {
                          Get.to(() => PostDetails(post: post));
                        },
                        child: Stack(
                          children: [
                            Container(
                              width: double.infinity,
                              decoration: BoxDecoration(
                                color: Colors.grey.shade300,
                                borderRadius: BorderRadius.circular(20),
                              ),
                              padding: const EdgeInsets.all(10),
                              child: Row(
                                children: [
                                  Container(
                                    height: 85,
                                    width: 85,
                                    decoration: BoxDecoration(
                                      color: Colors.grey.shade200,
                                      borderRadius: BorderRadius.circular(20),
                                    ),
                                    child: Image.network(post.car.Url),
                                  ),
                                  const SizedBox(width: 10),
                                  Column(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: [
                                      Text(
                                        post.car.name ?? 'No name',
                                        style: const TextStyle(
                                          color: Colors.black,
                                          fontWeight: FontWeight.bold,
                                          fontSize: 18,
                                        ),
                                      ),
                                      Text(
                                        post.car.category ?? 'No category',
                                        style: const TextStyle(
                                          color: Colors.grey,
                                          fontWeight: FontWeight.bold,
                                          fontSize: 18,
                                        ),
                                      ),
                                      Text(
                                        post.car.price != null
                                            ? '\$${post.car.price}'
                                            : 'Call for the price',
                                        style: const TextStyle(
                                          color: Colors.black,
                                          fontWeight: FontWeight.bold,
                                          fontSize: 18,
                                        ),
                                      ),
                                    ],
                                  ),
                                  const Spacer(),
                                  IconButton(
                                    icon: Icon(
                                      isFavorite
                                          ? Icons.favorite
                                          : Icons.favorite_border,
                                      color: isFavorite ? Colors.red : null,
                                    ),
                                    onPressed: () async {
                                      try {
                                        await likecontroller
                                            .toggleFavorite(post.id);
                                      } catch (e) {
                                        Get.snackbar('Error', e.toString());
                                      }
                                    },
                                  ),
                                ],
                              ),
                            )
                          ],
                        ),
                      );
                    },
                    separatorBuilder: (context, index) =>
                        const SizedBox(height: 20),
                    itemCount: postsToDisplay.length,
                  );
                }),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
