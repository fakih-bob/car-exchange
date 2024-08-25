import 'package:carexchange/Components/Categories.dart';
import 'package:carexchange/Components/PostsPageBar.dart';
import 'package:carexchange/Components/SearchBar.dart';
import 'package:carexchange/Controller/PostController.dart';
import 'package:carexchange/View/PostDetails.dart';
import 'package:carexchange/models/Category.dart';
import 'package:carexchange/models/Post.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class Postspage extends StatefulWidget {
  const Postspage({super.key});

  @override
  State<Postspage> createState() => _PostspageState();
}

class _PostspageState extends State<Postspage> {
  @override
  Widget build(BuildContext context) {
    final PostController controller = Get.put(PostController());

    return GetX<PostController>(builder: (_) {
      return Scaffold(
        backgroundColor: Colors.white,
        body: SafeArea(
            child: Padding(
          padding: const EdgeInsets.all(10),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const PostsPageBar(),
              const SizedBox(
                height: 20,
              ),
              const Searchbar(),
              const SizedBox(
                height: 20,
              ),
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
                                    image: AssetImage(
                                        'assets/images/Header.jpg'))),
                          );
                        }),
                  )
                ],
              ),
              const SizedBox(
                height: 10,
              ),
              const Categories(),
              const SizedBox(
                height: 10,
              ),
              const Text(
                "Items",
                style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
              ),
              Expanded(
                child: ListView.separated(
                  padding: const EdgeInsets.all(20),
                  itemBuilder: (context, index) {
                    var post = controller
                        .posts[index]; // Get the post from the controller
                    return InkWell(
                      onTap: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => PostDetails(post: post),
                          ),
                        );
                      },
                      child: Stack(
                        children: [
                          Container(
                            width: double.infinity,
                            decoration: BoxDecoration(
                                color: Colors.grey.shade300,
                                borderRadius: BorderRadius.circular(20)),
                            padding: const EdgeInsets.all(10),
                            child: Row(
                              children: [
                                Container(
                                  height: 85,
                                  width: 85,
                                  decoration: BoxDecoration(
                                      color: Colors.grey.shade200,
                                      borderRadius: BorderRadius.circular(20)),
                                  child: Image.network(
                                      post.car.url), // Use the post data
                                ),
                                const SizedBox(
                                  width: 10,
                                ),
                                Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      post.car.name, // Use the post data
                                      style: const TextStyle(
                                          color: Colors.black,
                                          fontWeight: FontWeight.bold,
                                          fontSize: 18),
                                    ),
                                    Text(
                                      post.car.category, // Use the post data
                                      style: const TextStyle(
                                          color: Colors.grey,
                                          fontWeight: FontWeight.bold,
                                          fontSize: 18),
                                    ),
                                    Text(
                                      post.car.price != null
                                          ? '\$${post.car.price}'
                                          : 'Price not available', // Use the post data
                                      style: const TextStyle(
                                          color: Colors.black,
                                          fontWeight: FontWeight.bold,
                                          fontSize: 18),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          )
                        ],
                      ),
                    );
                  },
                  separatorBuilder: (context, index) => const SizedBox(
                    height: 20,
                  ),
                  itemCount: controller
                      .posts.length, // Use the length of the posts list
                ),
              )
            ],
          ),
        )),
      );
    });
  }
}
