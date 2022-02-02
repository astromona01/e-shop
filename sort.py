from datetime import datetime
from random import randrange

# Создает массив случайных целых чисел размера n
def rarr(n):
    arr = []
    for i in range(n):
        arr.append(randrange(n))
    return arr

# Сортировка пузырьком
def bubble_sort(arr):
    n = len(arr)
    if (n <= 30):
        print(arr)
    for i in range(n-1):
        for j in range(0, n-i-1):
            if arr[j] > arr[j + 1] :
                arr[j], arr[j + 1] = arr[j + 1], arr[j]
    if (n <= 30):
        print(arr)

# Слияние двух отсортированных массивов
def _merge(left, right):
    result = []
    i, j = 0, 0
    while i < len(left) and j < len(right):
        if (left[i] < right[j]):
            result.append(left[i])
            i += 1
        else:
            result.append(right[j])
            j += 1
    while i < len(left):
        result.append(left[i])
        i += 1
    while j < len(right):
        result.append(right[j])
        j += 1
    return result
 
#  Рекурсивное деление массива
def merge_sort(arr):
    if len(arr) < 2:
        return arr[:]
    else:
        middle = int(len(arr) / 2)
        left = merge_sort(arr[:middle])
        right = merge_sort(arr[middle:])
        return _merge(left, right)

n = 1000000
print("\n")

# a = rarr(n)
# t = datetime.now()
# bubble_sort(a)
# t = datetime.now()- t
# print('Bubble sort time:')
# print(t)
# print("\n")

a = rarr(n)
if (len(a) <= 30):
    print(a)
t = datetime.now()
a = merge_sort(a)
t = datetime.now()- t
print('Merge sort time:')
print(t)
if (len(a) <= 30):
    print(a)
print("\n")

# bubble 100k ~ 1min   0,2-0,4s 

