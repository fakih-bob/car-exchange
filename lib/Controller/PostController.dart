import 'dart:convert';

import 'package:carexchange/Core/networks/Dioclient.dart';
import 'package:carexchange/models/Post.dart';
import 'package:get/get.dart';

class PostController extends GetxController {
  var posts = <Post>[].obs;
  @override
  void onInit() async {
    super.onInit();
    getPosts();
  }

  void getPosts() async {
    var request = await DioClient().getInstance().get('/posts');
    if (request.statusCode == 200) {
      var request_data = request.data as List;
      posts.value = request_data.map((posts) => Post.fromJson(posts)).toList();
    }
  }
}
