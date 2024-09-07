import 'package:carexchange/Controller/MyPostsController.dart';
import 'package:carexchange/Controller/PostController.dart';
import 'package:carexchange/Controller/UpdateController.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/View/UpdatePost.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:carexchange/Controller/LikeController.dart';

class MyPosts extends StatelessWidget {
  const MyPosts({super.key});

  @override
  Widget build(BuildContext context) {
    final MypostsController myPosts = Get.put(MypostsController());
    final PostController controller1 = Get.put(PostController());

    return GetX<LikeController>(
      builder: (controller) {
        return Scaffold(
          backgroundColor: Colors.white,
          appBar: AppBar(
            automaticallyImplyLeading: true,
            title: const Text("Your Posts"),
            elevation: 0,
            backgroundColor: Colors.transparent,
          ),
          drawer: Drawer(
            backgroundColor: Colors.purple,
            child: Column(
              mainAxisAlignment: MainAxisAlignment.end,
              children: [
                const Text(
                  "Hello, welcome!",
                  style: TextStyle(color: Colors.green),
                ),
                const SizedBox(height: 20),
                ElevatedButton(
                  onPressed: () {
                    Get.offNamed(
                        AppRoute.newpost); // Adjust route name if needed
                  },
                  child: const Text("New Post"),
                ),
                const SizedBox(height: 550),
                ElevatedButton(
                  onPressed: () {
                    controller1.logOut();
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
                  const Text(
                    "My Posts",
                    style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
                  ),
                  Expanded(
                    child: myPosts.MyPosts.isEmpty
                        ? const Center(
                            child: Text(
                              "No Posts for you yet.",
                              style: TextStyle(fontSize: 18),
                            ),
                          )
                        : ListView.separated(
                            padding: const EdgeInsets.all(20),
                            itemBuilder: (context, index) {
                              final post = myPosts.MyPosts[index];
                              final postId = post.MyPostId; // Get post ID here

                              return Container(
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
                                      child: Image.network(
                                        post.car.Url,
                                        fit: BoxFit.cover,
                                      ),
                                    ),
                                    const SizedBox(width: 10),
                                    Expanded(
                                      child: Column(
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
                                                : 'No price',
                                            style: const TextStyle(
                                              color: Colors.black,
                                              fontWeight: FontWeight.bold,
                                              fontSize: 18,
                                            ),
                                          ),
                                        ],
                                      ),
                                    ),
                                    IconButton(
                                      onPressed: () {
                                        Get.to(() => UpdatePost(
                                              postId: postId,
                                            ));
                                      },
                                      icon: const Icon(
                                        Icons.edit,
                                        color: Colors.blue,
                                      ),
                                    ),
                                    IconButton(
                                      onPressed: () {
                                        myPosts.deletePost(postId);
                                      },
                                      icon: const Icon(
                                        Icons.delete,
                                        color: Colors.red,
                                      ),
                                    ),
                                  ],
                                ),
                              );
                            },
                            separatorBuilder: (context, index) =>
                                const SizedBox(height: 20),
                            itemCount: myPosts.MyPosts.length,
                          ),
                  ),
                ],
              ),
            ),
          ),
        );
      },
    );
  }
}
