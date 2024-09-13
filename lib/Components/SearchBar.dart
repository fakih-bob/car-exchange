import 'package:carexchange/Controller/PostController.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class Searchbar extends StatelessWidget {
  const Searchbar({super.key});

  @override
  Widget build(BuildContext context) {
    // Use Get.find to access the existing PostController instance.
    final PostController controller = Get.find<PostController>();

    return Container(
      height: 55,
      width: double.infinity,
      decoration: BoxDecoration(
        color:
            Colors.grey.shade200, // Slightly lighter background for readability
        borderRadius: BorderRadius.circular(30),
      ),
      padding: const EdgeInsets.symmetric(
          horizontal: 20, vertical: 5), // Adjust padding
      child: Row(
        children: [
          const Icon(
            Icons.search,
            color: Colors.black,
            size: 24, // Adjust size for better alignment
          ),
          const SizedBox(width: 10), // Space between icon and text field
          Flexible(
            flex: 4,
            child: TextField(
              decoration: const InputDecoration(
                hintText: "Search ...",
                border: InputBorder.none,
              ),
              onChanged: (value) {
                controller.searchPosts(value);
              },
            ),
          ),
          const SizedBox(width: 10),
          Container(
            height: 30,
            width: 1.5,
            color: Colors.black,
          ),
          const SizedBox(width: 10),
          IconButton(
            onPressed: () {
              // TODO: Add filter functionality
            },
            icon: const Icon(Icons.filter_alt_rounded),
            color: Colors.black, // Match icon color with search icon
          ),
        ],
      ),
    );
  }
}
