import 'dart:io';
import 'package:carexchange/Core/networks/DioClient-auth.dart';
import 'package:carexchange/Core/networks/DioClient.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/models/User.dart';
import 'package:dio/dio.dart';
import 'package:flutter/cupertino.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

class RegistrationController extends GetxController {
  TextEditingController email = TextEditingController();
  TextEditingController password = TextEditingController();
  TextEditingController name = TextEditingController();
  TextEditingController phoneNumber = TextEditingController();

  late SharedPreferences prefs;
  late DioClient1 dioClient;
  @override
  void onInit() async {
    super.onInit();
    prefs = await SharedPreferences.getInstance();
    dioClient = DioClient1(prefs);
  }

  Future<void> register() async {
    if (name.text.isEmpty) {
      name.text = 'name is required';
    }

    if (email.text.isEmpty) {
      email.text = 'email is required';
    }

    if (password.text.isEmpty) {
      password.text = 'password is required';
    }

    if (phoneNumber.text.isEmpty) {
      phoneNumber.text = 'PhoneNumber is required';
    } else {
      User user = User(
          name: name.text,
          email: email.text,
          password: password.text,
          phoneNumber: phoneNumber.text);
      String requestBody = user.toJson();

      try {
        var response = await DioClient()
            .getInstance()
            .post("/register", data: requestBody);

        if (response.statusCode == 200) {
          // Handle successful registration
          print("User Registered Successfully");
          print(response.data);

          String token =
              response.data['token']; // Assuming your API returns a token
          await prefs.setString('token', token);

          // Set token for future requests
          dioClient.setAuthorizationToken(token);

          // Navigate to posts page after registration and login
          Get.offNamed(AppRoute.posts);
        } else {
          print('Error: ${response.statusCode} ${response.statusMessage}');
        }
      } on DioException catch (e) {
        if (e.type == DioExceptionType.connectionError) {
          if (e.error is SocketException) {
            print('Socket Exception: ${e.error}');
          } else {
            print('Connection Error: ${e.message}');
          }
        } else if (e.type == DioExceptionType.connectionTimeout ||
            e.type == DioExceptionType.receiveTimeout) {
          print('Timeout Exception: $e');
        } else {
          print('Dio Exception: $e');
        }
      } catch (e) {
        print('Error: $e');
      }
    }
  }
}
