import 'package:carexchange/Core/networks/DioClient-auth.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/models/Registration.dart';
import 'package:flutter/cupertino.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

class LoginController extends GetxController {
  TextEditingController email = TextEditingController();
  TextEditingController password = TextEditingController();

  late SharedPreferences prefs;
  late DioClient1 dioClient;

  @override
  void onInit() async {
    super.onInit();
    prefs = await SharedPreferences.getInstance();
    dioClient = DioClient1(prefs);
    if (prefs.getString('token') != null) {
      Get.offNamed(
          AppRoute.posts); // Navigate to posts page if already logged in
    }
  }

  void login() async {
    if (email.text.isEmpty) {
      Get.snackbar('Error', 'Email is required');
      return;
    }
    if (password.text.isEmpty) {
      Get.snackbar('Error', 'Password is required');
      return;
    }

    RegistrationUser user = RegistrationUser(
      email: email.value.text,
      password: password.value.text,
    );
    String requestBody = user.toJson();

    try {
      final response =
          await dioClient.getInstance().post("/login", data: requestBody);

      if (response.statusCode == 200) {
        if (response.data['status'] == true) {
          // Login success
          await prefs.setString('token', response.data['token']);
          dioClient.setAuthorizationToken(response.data['token']);
          print("Logged in successfully");
          Get.offNamed(AppRoute.posts);
        } else {
          // Invalid email or password
          Get.snackbar('Login Failed', response.data['message']);
        }
      } else {
        Get.snackbar('Error', 'Server error: ${response.statusCode}');
      }
    } catch (e) {
      print("Error during login: ${e.toString()}");
      Get.snackbar('Error', 'An error occurred during login');
    }
  }
}
