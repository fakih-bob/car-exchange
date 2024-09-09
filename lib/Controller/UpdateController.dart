import 'package:carexchange/Controller/PostController.dart';
import 'package:carexchange/Core/networks/DioClient-auth.dart';
import 'package:carexchange/models/UpdatingPost.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Updatecontroller extends GetxController {
  late DioClient1 dioClient1;
  final PostController postController = PostController();

  var selectedOption = ''.obs;
  final name = TextEditingController();
  final brand = TextEditingController();
  final color = TextEditingController();
  final description = TextEditingController();
  final miles = TextEditingController();
  final price = TextEditingController();
  final year = TextEditingController();
  final url = TextEditingController();
  final country = TextEditingController();
  final city = TextEditingController();
  final street = TextEditingController();
  final addressDescription = TextEditingController();
  final url1 = TextEditingController();
  final url2 = TextEditingController();
  final url3 = TextEditingController();
  final url4 = TextEditingController();
  final url5 = TextEditingController();

  @override
  void onInit() async {
    super.onInit();
    final prefs = await SharedPreferences.getInstance();
    dioClient1 = DioClient1(prefs);
  }

  Future<UpdatingPost?> getPostById(int id) async {
    try {
      var response = await dioClient1.getInstance().get('/post/$id');
      if (response.statusCode == 200) {
        return UpdatingPost.fromJson(response.data);
      } else {
        Get.snackbar('Error', 'Failed to fetch post: ${response.statusCode}');
      }
    } catch (e) {
      Get.snackbar('Error', 'Failed to fetch post: $e');
    }
    return null;
  }

  void updateFormFields(UpdatingPost post) {
    if (post == null) {
      Get.snackbar('Error', 'Post data is null');
      return;
    }

    // Update form fields with post data
    selectedOption.value = post.car.category ?? '';
    name.text = post.car.name ?? '';
    brand.text = post.car.brand ?? '';
    color.text = post.car.color ?? '';
    year.text = post.car.year?.toString() ?? '';
    price.text = post.car.price?.toString() ?? '';
    miles.text = post.car.miles?.toString() ?? '';
    description.text = post.car.description ?? '';
    url.text = post.car.Url ?? '';
    country.text = post.address.country ?? '';
    city.text = post.address.city ?? '';
    street.text = post.address.street ?? '';
    addressDescription.text = post.address.description ?? '';

    // Update picture URLs
    final pictures = post.pictures;
    url1.text = pictures.isNotEmpty ? pictures[0].url ?? '' : '';
    url2.text = pictures.length > 1 ? pictures[1].url ?? '' : '';
    url3.text = pictures.length > 2 ? pictures[2].url ?? '' : '';
    url4.text = pictures.length > 3 ? pictures[3].url ?? '' : '';
    url5.text = pictures.length > 4 ? pictures[4].url ?? '' : '';
  }

  Future<void> updatePost(int postId) async {
    if (selectedOption.value.isEmpty) {
      Get.snackbar('Error', 'Please select a category');
      return;
    }

    final updatedPost = {
      'address': {
        'country': country.text,
        'street': street.text,
        'city': city.text,
        'description': addressDescription.text,
      },
      'car': {
        'category': selectedOption.value,
        'brand': brand.text,
        'name': name.text,
        'color': color.text,
        'description': description.text,
        'miles': double.tryParse(miles.text),
        'year': int.tryParse(year.text),
        'Url': url.text,
        'price': double.tryParse(price.text),
      },
      'pictures': [
        if (url1.text.isNotEmpty) {'Url': url1.text},
        if (url2.text.isNotEmpty) {'Url': url2.text},
        if (url3.text.isNotEmpty) {'Url': url3.text},
        if (url4.text.isNotEmpty) {'Url': url4.text},
        if (url5.text.isNotEmpty) {'Url': url5.text},
      ]
    };

    try {
      var response = await dioClient1
          .getInstance()
          .put('/$postId/updatePost', data: updatedPost);

      if (response.statusCode == 200) {
        Get.snackbar('Success', 'Post updated successfully');
        postController.getPosts();
      } else {
        Get.snackbar('Error', 'Failed to update post: ${response.statusCode}');
      }
    } catch (e) {
      Get.snackbar('Error', 'An error occurred: $e');
    }
  }
}
