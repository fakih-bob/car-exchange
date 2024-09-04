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
    var request = await DioClient().getInstance().get('/posts');
    if (request.statusCode == 200) {
      var requestdata = request.data as List;
      posts.value = requestdata.map((post) => Post.fromJson(post)).toList();
    }
  }

  void logOut() async {
    await prefs.remove('token');
    Get.offNamed(AppRoute.login);
  }
}
