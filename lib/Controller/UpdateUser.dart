import 'package:carexchange/Controller/PostController.dart';
import 'package:carexchange/Controller/UserContoller.dart';
import 'package:carexchange/Core/networks/DioClient-auth.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/models/User.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Updateusercontroller extends GetxController {
  late DioClient1 dioClient1;
  final PostController postController = PostController();
  final UserController userController = UserController();

  final name = TextEditingController();
  final email = TextEditingController();
  final phoneNumber = TextEditingController();

  @override
  void onInit() async {
    super.onInit();
    final prefs = await SharedPreferences.getInstance();
    dioClient1 = DioClient1(prefs);
  }

  void updateFormFields(User user) {
    name.text = user.name;
    email.text = user.email;
    phoneNumber.text = user.phoneNumber;
  }

  Future<void> updateuser() async {
    // Check if any field is empty
    if (name.text.isEmpty) {
      Get.snackbar('Validation Error', 'Name is required');
      return;
    }

    if (email.text.isEmpty) {
      Get.snackbar('Validation Error', 'Email is required');
      return;
    }

    if (phoneNumber.text.isEmpty) {
      Get.snackbar('Validation Error', 'Phone number is required');
      return;
    }

    final updatedUser = {
      "name": name.text,
      "email": email.text,
      "phoneNumber": phoneNumber.text
    };

    try {
      final response =
          await dioClient1.getInstance().put('/UserUpdate', data: updatedUser);

      if (response.statusCode == 200) {
        Get.snackbar('Success', 'User info updated successfully');
        Get.offNamed(AppRoute.user);
      } else {
        Get.snackbar('Error', 'Failed to update user info');
      }
    } catch (e) {
      Get.snackbar('Error', 'An error occurred: ${e.toString()}');
    }
  }

  Future<void> DeleteUser() async {
    try {
      final response = await dioClient1.getInstance().delete('/UserDelete');

      if (response.statusCode == 200) {
        Get.snackbar('Success', 'User removed successfully');
      } else {
        Get.snackbar('Error', 'Failed to remove user: ${response.statusCode}');
      }
    } catch (e) {
      Get.snackbar('Error', 'Failed to remove user: ${e.toString()}');
    }
  }
}
