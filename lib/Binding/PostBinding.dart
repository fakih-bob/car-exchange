import 'package:carexchange/Controller/PostController.dart';
import 'package:get/get.dart';

class Postbinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut(() => PostController());
  }
}
