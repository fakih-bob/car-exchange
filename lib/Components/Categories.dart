import 'package:carexchange/models/Category.dart';
import 'package:flutter/material.dart';

class Categories extends StatelessWidget {
  const Categories({super.key});

  @override
  Widget build(BuildContext context) {
    return SizedBox(
        height: 90,
        child: ListView.separated(
          scrollDirection: Axis.horizontal,
          itemBuilder: (context, index) {
            return Column(
              children: [
                Container(
                  height: 60,
                  width: 60,
                  decoration: BoxDecoration(
                      shape: BoxShape.circle,
                      image: DecorationImage(
                          image: AssetImage(categories[index].image))),
                ),
                const SizedBox(height: 7),
                Text(
                  categories[index].title,
                  style: const TextStyle(
                      fontWeight: FontWeight.bold, fontSize: 14),
                )
              ],
            );
          },
          separatorBuilder: (context, index) => const SizedBox(
            width: 20,
          ),
          itemCount: categories.length,
        ));
  }
}
