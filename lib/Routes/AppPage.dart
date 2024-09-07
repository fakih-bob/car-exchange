import 'package:carexchange/Binding/LikeBinding.dart';
import 'package:carexchange/Binding/LoginBinding.dart';
import 'package:carexchange/Binding/MyPostsBinding.dart';
import 'package:carexchange/Binding/PostBinding.dart';
import 'package:carexchange/Binding/PostingBinding.dart';
import 'package:carexchange/Binding/RegistrationBinding.dart';
import 'package:carexchange/Binding/UserBinding.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/View/Login.dart';
import 'package:carexchange/View/MyLikes.dart';
import 'package:carexchange/View/MyPosts.dart';
import 'package:carexchange/View/NewPost.dart';
import 'package:carexchange/View/PostsPage.dart';
import 'package:carexchange/View/Registration.dart';
import 'package:carexchange/View/UserProfile.dart';
import 'package:get/get.dart';

class AppPage {
  static final List<GetPage> pages = [
    GetPage(
        name: AppRoute.posts, page: () => Postspage(), binding: Postbinding()),
    GetPage(
        name: AppRoute.register,
        page: () => Registration(),
        binding: Registrationbinding()),
    GetPage(name: AppRoute.login, page: () => Login(), binding: Loginbinding()),
    GetPage(
        name: AppRoute.newpost,
        page: () => NewPost(),
        binding: Postingbinding()),
    GetPage(
        name: AppRoute.MyLikes, page: () => MyLikes(), binding: Likebinding()),
    GetPage(
        name: AppRoute.MyPosts,
        page: () => MyPosts(),
        binding: Mypostsbinding()),
    GetPage(
        name: AppRoute.user, page: () => UserProfile(), binding: Userbinding()),
  ];
}
