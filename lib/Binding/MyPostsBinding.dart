import 'package:carexchange/Controller/MyPostsController.dart';
import 'package:get/get.dart';

class Mypostsbinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut(() => MypostsController());
  }
}
