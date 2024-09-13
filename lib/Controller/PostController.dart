import 'package:carexchange/Controller/LikeController.dart';
import 'package:carexchange/Core/networks/Dioclient.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/models/Post.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

class PostController extends GetxController {
  var posts = <Post>[].obs;
  var filteredPosts = <Post>[].obs;
  final LikeController likeController = Get.put(LikeController());
  late SharedPreferences prefs;

  @override
  void onInit() async {
    super.onInit();
    await _loadSharedPreferences();
    getPosts();
    likeController.loadFavorites();
  }

  Future<void> _loadSharedPreferences() async {
    prefs = await SharedPreferences.getInstance();
  }

  void getPosts() async {
    var response = await DioClient().getInstance().get('/posts');
    if (response.statusCode == 200) {
      var requestData = response.data as List;
      posts.value = requestData.map((post) => Post.fromJson(post)).toList();
      filteredPosts.value = List.from(posts);
      likeController.loadFavorites(); // Initialize filteredPosts with all posts
    }
  }

  void searchPosts(String query) {
    if (query.isEmpty) {
      // If the search query is empty, show all posts
      filteredPosts.value = List.from(posts);
    } else {
      // Filter posts based on the search query
      filteredPosts.value = posts.where((post) {
        return post.car.name != null &&
            post.car.name.toLowerCase().contains(query.toLowerCase());
      }).toList();
    }
  }

  void getPostByCategory(String category) async {
    var response =
        await DioClient().getInstance().get('/fetchByCategory/$category');
    posts.value = [];
    if (response.statusCode == 200) {
      var requestData = response.data as List;
      posts.value = requestData.map((post) => Post.fromJson(post)).toList();
      filteredPosts.value = List.from(posts); // Update the filtered posts list
    }
  }

  void logOut() async {
    await prefs.remove('token');
    Get.offNamed(AppRoute.login);
  }
}
