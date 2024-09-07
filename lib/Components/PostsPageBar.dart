import 'package:carexchange/Routes/AppRoute.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_core/src/get_main.dart';

class PostsPageBar extends StatelessWidget {
  const PostsPageBar({super.key});

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        SizedBox(
          width: 100,
        ),
        IconButton(
          onPressed: () {
            Get.offNamed(AppRoute.user);
          },
          style: IconButton.styleFrom(
              backgroundColor: Colors.grey, padding: const EdgeInsets.all(15)),
          iconSize: 25,
          icon: const Icon(Icons.person),
        )
      ],
    );
  }
}
