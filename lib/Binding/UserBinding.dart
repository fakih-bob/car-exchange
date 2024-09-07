import 'package:carexchange/Controller/UserContoller.dart';
import 'package:get/get.dart';

class Userbinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut(() => UserController());
  }
}
