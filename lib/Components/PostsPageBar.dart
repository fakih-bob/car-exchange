import 'package:flutter/material.dart';

class PostsPageBar extends StatelessWidget {
  const PostsPageBar({super.key});

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        IconButton(
          onPressed: () {},
          style: IconButton.styleFrom(
              backgroundColor: Colors.grey.shade200,
              padding: const EdgeInsets.all(15)),
          iconSize: 25,
          icon: const Icon(Icons.menu),
        ),
        IconButton(
          onPressed: () {},
          style: IconButton.styleFrom(
              backgroundColor: Colors.grey.shade200,
              padding: const EdgeInsets.all(15)),
          iconSize: 25,
          icon: const Icon(Icons.person),
        )
      ],
    );
  }
}
