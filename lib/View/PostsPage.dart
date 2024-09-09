import 'package:carexchange/Components/Categories.dart';
import 'package:carexchange/Components/PostsPageBar.dart';
import 'package:carexchange/Components/SearchBar.dart';
import 'package:carexchange/Controller/LikeController.dart';
import 'package:carexchange/Controller/PostController.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/View/PostDetails.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class Postspage extends StatefulWidget {
  const Postspage({super.key});

  @override
  State<Postspage> createState() => _PostspageState();
}

class _PostspageState extends State<Postspage> {
  final PostController controller = Get.put(PostController());
  final LikeController likecontroller = Get.put(LikeController());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
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
            SizedBox(height: 55),
            const Text(
              "Welcome, User!",
              style: TextStyle(
                  color: Colors.white,
                  fontSize: 20,
                  fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                Get.offNamed(AppRoute.newpost);
              },
              child: const Text("New post"),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                Get.offNamed(AppRoute.MyLikes);
              },
              child: const Text("Show my favorites"),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                Get.offNamed(AppRoute.MyPosts);
              },
              child: const Text("Show my posts"),
            ),
            const Spacer(),
            ElevatedButton(
              onPressed: () {
                controller.logOut();
              },
              child: const Text("Logout"),
            ),
            const SizedBox(height: 40),
          ],
        ),
      ),
      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.all(10),
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
              const Categories(),
              const SizedBox(height: 10),
              const Text(
                "Items",
                style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
              ),
              Expanded(
                child: Obx(() {
                  var posts = controller.posts;

                  if (posts.isEmpty) {
                    return Center(child: Text("No posts available"));
                  }

                  return ListView.separated(
                    padding: const EdgeInsets.all(20),
                    itemBuilder: (context, index) {
                      var post = posts[index];
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
                                  Spacer(),
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
                    itemCount: posts.length,
                  );
                }),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
