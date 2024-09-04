import 'package:carexchange/Core/networks/DioClient-auth.dart';
import 'package:carexchange/models/MyPosts.dart';
import 'package:carexchange/models/Post.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

class MypostsController extends GetxController {
  var MyPosts = <MyPost>[].obs;
  late DioClient1 dioClient;

  @override
  void onInit() async {
    super.onInit();
    final prefs = await SharedPreferences.getInstance();
    dioClient =
        DioClient1(prefs); // Initialize DioClient1 for authenticated requests
    getMyPosts();
  }

  // Function to toggle the favorite status of a post

  void getMyPosts() async {
    var request = await dioClient.getInstance().get('/ListMyPosts');
    if (request.statusCode == 200) {
      var requestdata = request.data as List;
      MyPosts.value = requestdata.map((post) => MyPost.fromJson(post)).toList();
    }
  }
}
