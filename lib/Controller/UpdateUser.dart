import 'package:carexchange/Controller/PostController.dart';
import 'package:carexchange/Controller/UserContoller.dart';
import 'package:carexchange/Core/networks/DioClient-auth.dart';
import 'package:carexchange/models/Post.dart';
import 'package:carexchange/models/UpdatingPost.dart';
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
    final UpdatedUser = {
      "name": name.text,
      "email": email.text,
      "phoneNumber": phoneNumber.text
    };

    try {
      var response =
          await dioClient1.getInstance().put('/UserUpdate', data: UpdatedUser);

      if (response.statusCode == 200) {
        Get.snackbar('Success', 'UserInfo updated successfully');
      } else {
        Get.snackbar('Error', 'Failed to update post');
      }
    } catch (e) {
      Get.snackbar('Error', 'An error occurred: $e');
    }
  }
}
