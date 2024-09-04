import 'package:carexchange/Controller/NewPostController.dart';
import 'package:get/get.dart';

class Postingbinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut(() => Newpostcontroller());
  }
}
