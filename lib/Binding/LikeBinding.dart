import 'package:carexchange/Controller/LikeController.dart';
import 'package:get/get.dart';

class Likebinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut(() => LikeController());
  }
}
