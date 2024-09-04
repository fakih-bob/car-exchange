import 'dart:io';

import 'package:carexchange/Core/networks/DioClient.dart';
import 'package:carexchange/models/User.dart';
import 'package:dio/dio.dart';
import 'package:flutter/cupertino.dart';
import 'package:get/get.dart';

class RegistrationController extends GetxController {
  TextEditingController email = TextEditingController();
  TextEditingController password = TextEditingController();
  TextEditingController name = TextEditingController();
  TextEditingController phoneNumber = TextEditingController();

  Future<void> register() async {
    User user = User(
        name: name.text,
        email: email.text,
        password: password.text,
        phoneNumber: phoneNumber.text);
    String request_Body = user.toJson();

    try {
      var response =
          await DioClient().getInstance().post("/register", data: request_Body);
      if (response.statusCode == 200) {
        // Replace with your success dialog or handling
        print("User Registered Successfully");
        print(response.data);
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
