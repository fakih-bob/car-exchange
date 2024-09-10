import 'package:carexchange/Routes/AppRoute.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

class PostsPageBar extends StatelessWidget {
  const PostsPageBar({super.key});

  Future<bool> _isLoggedIn() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('token') != null;
  }

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        const SizedBox(
          width: 100,
        ),
        FutureBuilder<bool>(
          future: _isLoggedIn(),
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const CircularProgressIndicator();
            }

            final isLoggedIn = snapshot.data ?? false;

            return IconButton(
              onPressed: isLoggedIn
                  ? () {
                      Get.offNamed(AppRoute.user);
                    }
                  : () {
                      // Show a message or redirect to login page
                      Get.snackbar(
                          'Not Logged In', 'Please log in to continue.',
                          snackPosition: SnackPosition.BOTTOM);
                    },
              iconSize: 25,
              icon: const Icon(Icons.person),
              color: isLoggedIn
                  ? Colors.blue
                  : Colors.grey, // Change color based on login status
            );
          },
        ),
      ],
    );
  }
}
