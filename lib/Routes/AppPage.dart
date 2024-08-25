import 'package:carexchange/Binding/PostBinding.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/View/PostsPage.dart';
import 'package:get/get.dart';

class AppPage {
  static final List<GetPage> pages = [
    GetPage(
        name: AppRoute.login, page: () => Postspage(), binding: Postbinding()),
  ];
}
