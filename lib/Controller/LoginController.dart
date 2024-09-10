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
      Get.offNamed(AppRoute.posts);
    }
  }

  void login() async {
    if (email.text.isEmpty) {
      email.text = 'email is required';
    }
    if (password.text.isEmpty) {
      password.text = 'password is required';
    } else {
      RegistrationUser user = RegistrationUser(
          email: email.value.text, password: password.value.text);
      String requestBody = user.toJson();

      try {
        final response =
            await dioClient.getInstance().post("/login", data: requestBody);

        if (response.statusCode == 200) {
          print(response.data);
          await prefs.setString('token', response.data['token']);
          dioClient.setAuthorizationToken(response.data['token']);
          print("logged in");
          Get.offNamed(AppRoute.posts); // Navigate to posts page after login
        } else {
          print("wrong email or password");
        }
      } catch (e) {
        print("Error during login: ${e.toString()}");
      }
    }
  }
}
