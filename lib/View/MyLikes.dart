import 'package:carexchange/Controller/PostController.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:carexchange/Controller/LikeController.dart';

class MyLikes extends StatelessWidget {
  const MyLikes({super.key});

  @override
  Widget build(BuildContext context) {
    final LikeController likeController = Get.put(LikeController());
    final PostController controller1 = Get.put(PostController());

    return GetX<LikeController>(
      builder: (controller) {
        return Scaffold(
          backgroundColor: Colors.white,
          appBar: AppBar(
            automaticallyImplyLeading: true,
            title: const Text("Favorite Posts"),
            elevation: 0,
            backgroundColor: Colors.transparent,
          ),
          drawer: Drawer(
            backgroundColor: const Color.fromARGB(255, 4, 59, 154),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.end,
              children: [
                SizedBox(
                  height: 55,
                ),
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
                    "Favorite Posts",
                    style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
                  ),
                  Expanded(
                    child: controller.favoritePosts.isEmpty
                        ? Center(
                            child: Text(
                              "No favorites yet.",
                              style: TextStyle(fontSize: 18),
                            ),
                          )
                        : ListView.separated(
                            padding: const EdgeInsets.all(20),
                            itemBuilder: (context, index) {
                              final postId =
                                  controller.favoritePosts.keys.toList()[index];
                              final post = controller.favoritePosts[postId]!;

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
                                          borderRadius:
                                              BorderRadius.circular(20),
                                        ),
                                        child: Image.network(
                                          post.car.Url,
                                          fit: BoxFit.cover,
                                        )),
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
                                                : 'Call for the price',
                                            style: const TextStyle(
                                              color: Colors.black,
                                              fontWeight: FontWeight.bold,
                                              fontSize: 18,
                                            ),
                                          ),
                                          Text(
                                            post.car.description ??
                                                'No description',
                                            style: const TextStyle(
                                              color: Colors.grey,
                                              fontSize: 16,
                                            ),
                                          ),
                                          Text(
                                            post.car.miles != null
                                                ? '${post.car.miles} miles'
                                                : 'Mileage unknown',
                                            style: const TextStyle(
                                              color: Colors.grey,
                                              fontSize: 16,
                                            ),
                                          ),
                                        ],
                                      ),
                                    ),
                                    IconButton(
                                      icon: Icon(
                                        controller.isFavorite(postId)
                                            ? Icons.favorite
                                            : Icons.favorite_border,
                                        color: controller.isFavorite(postId)
                                            ? Colors.red
                                            : null,
                                      ),
                                      onPressed: () async {
                                        try {
                                          await controller
                                              .toggleFavorite(postId);
                                        } catch (e) {
                                          Get.snackbar('Error', e.toString());
                                        }
                                      },
                                    ),
                                  ],
                                ),
                              );
                            },
                            separatorBuilder: (context, index) =>
                                const SizedBox(height: 20),
                            itemCount: controller.favoritePosts.length,
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
