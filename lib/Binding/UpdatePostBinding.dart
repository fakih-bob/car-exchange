import 'package:carexchange/Controller/UpdateController.dart';
import 'package:get/get.dart';

class Updatepostbinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut(() => Updatecontroller());
  }
}
