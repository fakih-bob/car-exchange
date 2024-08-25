import 'package:flutter/material.dart';

class Searchbar extends StatelessWidget {
  const Searchbar({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 55,
      width: double.infinity,
      decoration: BoxDecoration(
          color: Colors.grey, borderRadius: BorderRadius.circular(30)),
      padding: const EdgeInsets.symmetric(horizontal: 30, vertical: 5),
      child: Row(
        children: [
          const Icon(
            Icons.search,
            color: Colors.black,
          ),
          const SizedBox(
            height: 20,
          ),
          const Flexible(
            flex: 4,
            child: TextField(
              decoration: InputDecoration(
                  hintText: "Search ...", border: InputBorder.none),
            ),
          ),
          Container(
            height: 30,
            width: 1.5,
            color: Colors.black,
          ),
          IconButton(
            onPressed: () {},
            icon: Icon(Icons.filter_3),
            color: Colors.grey.shade200,
          )
        ],
      ),
    );
  }
}
