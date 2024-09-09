import 'dart:io';
import 'package:carexchange/Core/networks/DioClient-auth.dart';
import 'package:carexchange/models/Address.dart';
import 'package:carexchange/models/Car.dart';
import 'package:carexchange/models/Picture.dart';
import 'package:carexchange/models/Posting.dart';
import 'package:dio/dio.dart';
import 'package:flutter/cupertino.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Newpostcontroller extends GetxController {
  late DioClient1 dioClient1;

  var selectedOption = RxString('');
  TextEditingController name = TextEditingController();
  TextEditingController brand = TextEditingController();
  TextEditingController color = TextEditingController();
  TextEditingController description = TextEditingController();
  TextEditingController miles = TextEditingController();
  TextEditingController price = TextEditingController();
  TextEditingController year = TextEditingController();
  TextEditingController url = TextEditingController();
  TextEditingController country = TextEditingController();
  TextEditingController city = TextEditingController();
  TextEditingController street = TextEditingController();
  TextEditingController addressDescription = TextEditingController();
  TextEditingController url1 = TextEditingController();
  TextEditingController url2 = TextEditingController();
  TextEditingController url3 = TextEditingController();
  TextEditingController url4 = TextEditingController();
  TextEditingController url5 = TextEditingController();

  @override
  void onInit() async {
    super.onInit();
    final prefs = await SharedPreferences.getInstance();
    dioClient1 = DioClient1(prefs);
  }

  // List to store Picture objects
  List<Picture> pictureList = [];

  void addPictures() {
    pictureList.clear(); // Clear existing pictures before adding new ones

    if (url1.text.isNotEmpty) {
      pictureList.add(Picture(url: url1.text));
    }
    if (url2.text.isNotEmpty) {
      pictureList.add(Picture(url: url2.text));
    }
    if (url3.text.isNotEmpty) {
      pictureList.add(Picture(url: url3.text));
    }
    if (url4.text.isNotEmpty) {
      pictureList.add(Picture(url: url4.text));
    }
    if (url5.text.isNotEmpty) {
      pictureList.add(Picture(url: url5.text));
    }
  }

  Future<void> postingCar() async {
    addPictures(); // Call this method to populate pictureList

    Car car = Car(
        category: selectedOption.value,
        brand: brand.text,
        name: name.text,
        color: color.text,
        description: description.text,
        miles: double.tryParse(miles.text) ?? 0.0, // Handle parsing error
        year: int.tryParse(year.text) ?? 0,
        Url: url.text, // Ensure 'url' is used consistently
        price: double.tryParse(price.text) ?? 0.0);

    Address address = Address(
      country: country.text,
      street: street.text,
      city: city.text,
      description: addressDescription.text,
    );

    Posting user = Posting(
      car: car,
      address: address,
      pictures: pictureList, // Pass the list of pictures here
    );

    String requestBody = user.toJson();

    try {
      var response =
          await dioClient1.getInstance().post("/StorePost", data: requestBody);
      if (response.statusCode == 200) {
        // Replace with your success dialog or handling
        Get.snackbar('Success', 'Post created successfully');
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
