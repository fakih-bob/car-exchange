import 'package:carexchange/Core/networks/DioClient-auth.dart';
import 'package:carexchange/Core/networks/DioClient.dart';
import 'package:carexchange/models/Like.dart';
import 'package:get/get.dart';
import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';

class LikeController extends GetxController {
  // Using a single map to hold post details and favorite status
  var favoritePosts = <int, Like>{}.obs;
  late DioClient1 dioClient;

  // Define your API endpoints
  final String storeFavoriteUrl = '/{postId}/FavoriteList';
  final String deleteFavoriteUrl = '/{postId}/deleteFavorite';
  final String listFavoritesUrl = '/addFavorite';

  @override
  void onInit() async {
    super.onInit();
    final prefs = await SharedPreferences.getInstance();
    dioClient =
        DioClient1(prefs); // Initialize DioClient1 for authenticated requests
    loadFavorites(); // Load favorites when the controller is initialized
  }

  // Function to toggle the favorite status of a post
  Future<void> toggleFavorite(int postId) async {
    final isFavorite = favoritePosts.containsKey(postId);

    if (isFavorite) {
      await _deleteFavorite(postId);
    } else {
      await _storeFavorite(postId);
    }
  }

  // Function to add a post to favorites
  Future<void> _storeFavorite(int postId) async {
    try {
      final response = await dioClient.getInstance().post(
        storeFavoriteUrl.replaceAll('{postId}', postId.toString()),
        data: {'postId': postId},
      );

      if (response.statusCode == 200) {
        final like =
            Like.fromJson(response.data); // Create Like object from response
        favoritePosts[postId] = like;
      } else {
        print(
            'Failed to add favorite: ${response.statusCode} - ${response.statusMessage}');
        throw Exception('Failed to add favorite');
      }
    } catch (e) {
      Get.snackbar('Error', 'Failed to add favorite: ${e.toString()}');
    }
  }

  // Function to remove a post from favorites
  Future<void> _deleteFavorite(int postId) async {
    try {
      final response = await dioClient.getInstance().delete(
        deleteFavoriteUrl.replaceAll('{postId}', postId.toString()),
        data: {'postId': postId},
      );

      if (response.statusCode == 200) {
        favoritePosts.remove(postId); // Remove post from favorites
      } else {
        print(
            'Failed to remove favorite: ${response.statusCode} - ${response.statusMessage}');
        throw Exception('Failed to remove favorite');
      }
    } catch (e) {
      Get.snackbar('Error', 'Failed to remove favorite: ${e.toString()}');
    }
  }

  // Function to check if a post is a favorite
  bool isFavorite(int postId) {
    return favoritePosts.containsKey(postId);
  }

  Future<void> loadFavorites() async {
    try {
      final response = await dioClient.getInstance().get(listFavoritesUrl);

      if (response.statusCode == 200) {
        final List<dynamic> favoriteListData = response.data;
        favoritePosts.value = {
          for (var data in favoriteListData)
            data['post_id']: Like.fromJson(data),
        };
      } else {
        print(
            'Failed to load favorites: ${response.statusCode} - ${response.statusMessage}');
        throw Exception('Failed to load favorites');
      }
    } catch (e) {
      Get.snackbar('Error', 'Failed to load favorites: ${e.toString()}');
    }
  }
}
