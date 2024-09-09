import 'package:carexchange/Core/networks/Dioclient.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/models/Post.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

class PostController extends GetxController {
  var posts = <Post>[].obs;

  late SharedPreferences prefs;

  @override
  void onInit() async {
    super.onInit();
    await _loadSharedPreferences();
    getPosts();
  }

  Future<void> _loadSharedPreferences() async {
    prefs = await SharedPreferences.getInstance();
  }

  void getPosts() async {
    var response = await DioClient().getInstance().get('/posts');
    if (response.statusCode == 200) {
      var requestData = response.data as List;
      posts.value = requestData.map((post) => Post.fromJson(post)).toList();
    }
  }

  void getPostByCategory(String category) async {
    var response =
        await DioClient().getInstance().get('/fetchByCategory/$category');
    posts.value = [];
    if (response.statusCode == 200) {
      var requestData = response.data as List;
      posts.value = requestData.map((post) => Post.fromJson(post)).toList();
    }
  }

  void logOut() async {
    await prefs.remove('token');
    Get.offNamed(AppRoute.login);
  }
}
